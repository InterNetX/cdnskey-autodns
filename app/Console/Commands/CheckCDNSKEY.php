<?php
// vim: set filetype=php expandtab tabstop=2 shiftwidth=2 autoindent smartindent:

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Net_DNS2_Resolver;
use Net_DNS2_Exception;
use App\DNSZone;

class CheckCDNSKEY extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdnskey:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compare CDNSKEY and NS set at the nameserver with AutoDNS data and perform a domain update in case of any needed changes.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function requestCurl($data) {
	$ch = curl_init( config('autodns.url') );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        if( !$data = curl_exec( $ch )) {
                Log::error('Curl execution error.'.curl_error( $ch ));
        return FALSE;
        }
        curl_close( $ch );
        return $data;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	$domains = DNSZone::all();
	foreach ($domains as $dom) {
		$d = $dom->name;
		$s = $dom->server->ip;
		Log::info("Checking $d on $s");
		$all_ns = array();
		$required_ns = array();
		$r = new Net_DNS2_Resolver(array('nameservers' => array($s)));
		try {
			$result = $r->query($d, 'NS');        
		} catch(Net_DNS2_Exception $e) {
			Log::error("::query() NS $d failed: ".$e->getMessage());
			continue;
		}
		//
		foreach($result->answer as $nsrr)
		{
			// TODO: if GLUE then lookup all A, AAAA
			array_push($required_ns, $nsrr->nsdname);
		}

		sort($required_ns);

		$all_cdnskey_rr = array();
		$required_cdnskey = array();
		try {
			$result = $r->query($d, 'CDNSKEY');
		} catch(Net_DNS2_Exception $e) {
			Log::error("::query() CDNSKEY failed: ".$e->getMessage());
			continue;
		}
		foreach($result->answer as $cdnskeyrr) {
			array_push($all_cdnskey_rr, $cdnskeyrr);
			array_push($required_cdnskey, $cdnskeyrr->flags.' '.$cdnskeyrr->algorithm.' '.$cdnskeyrr->key);
		}

		$processedString = view('autodns_0105', ['name' => $d])->render();

		Log::info("Sending 0105 for $d");

		$aResponse = $this->requestCurl($processedString);

		if ($aResponse == false || $aResponse == '') {
			Log::info("Inquire for $d failed");
			continue;
		}

		$xml = new \SimpleXMLElement($aResponse);

		$status = (string)$xml->result->status->type;
		if ($status != 'success') {
			Log::info("Inquire $d $status");
			continue;
		}
		$autodns_ns = array();
		foreach ($xml->result->data->domain->nserver as $ns) {
			array_push($autodns_ns, (string)$ns->name);
			$glues = array();
			foreach ($ns->ip as $i) {
				array_push($glues, inet_ntop(inet_pton($i)));
			}
			foreach ($ns->ip6 as $i) {
				array_push($glues, inet_ntop(inet_pton($i)));
			}
			$ip_addon = '';
			if (sizeof($glues) > 0) {
				sort($glues);
				$ip_addon = ' '.implode(' ', $glues);
			}
			array_push($required_ns, $nsrr->nsdname.$ip_addon);
		}
		sort($autodns_ns);

		$ns_update = false;
		if (sizeof(array_diff($required_ns, $autodns_ns)) == 0 && sizeof(array_diff($autodns_ns, $required_ns)) == 0) {
			Log::info("Namserver for $d equal AutoDNS");
		} else {
			Log::info("Namserver for $d differ");
			$ns_update = true;
		}

		$autodns_dnskey = array();
		foreach ($xml->result->data->domain->dnssec as $ds) {
			array_push($autodns_dnskey, $ds->flags.' '.$ds->algorithm.' '.$ds->publickey);
		}

		$ds_update = false;
		if (sizeof($required_cdnskey) == 0) {
			Log::info("No CDNSKEY present for $d, will not update DNSKEY");
		} else if (sizeof(array_diff($required_cdnskey, $autodns_dnskey)) == 0 && sizeof(array_diff($autodns_dnskey, $required_cdnskey)) == 0) {
			Log::info("DNSKEY for $d present in AutoDNS");
		} else {
			$ds_update = true;
			Log::info("DNSKEY update required for $d");
		}
		if ($ns_update || $ds_update) {
			$function_code = '0102';
			if ($ns_update && $ds_update) {
			} else if ($ns_update) {
				$function_code = '0102008';
			} else {
				$function_code = '0102007';
			}
			$processedString = view('autodns_0102', [
				'function_code' => $function_code,
				'name' => $d,
				'ns' => $ns_update ? $all_ns : array(),
				'dnskey' => $all_cdnskey_rr,
			])->render();
			Log::info("Sending $function_code $d");
			$aResponse = $this->requestCurl($processedString);
			if ($aResponse == false || $aResponse == '') {
				Log::info("Update for $d failed");
				continue;
			}

			$xml = new \SimpleXMLElement($aResponse);

			$status = (string)$xml->result->status->type;
			Log::info("Update $d $status");
		}
	}
    }
}
