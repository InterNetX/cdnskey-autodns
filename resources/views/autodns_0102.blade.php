@extends('autodns')
@section('task')
		<code>{{ $function_code }}</code>
		<domain>
			<name>{{ $name }}</name>
@foreach ($ns as $n)
			<nserver>
				<name>{{ $n['name'] }}</name>
@foreach ($n['ip'] as $i)
				<ip>{{ $i }}</ip>
@endforeach
@foreach ($n['ip6'] as $i6)
				<ip6>{{ $i6 }}</ip6>
@endforeach

			</nserver>
@endforeach
@foreach ($dnskey as $d)
			<dnssec>
				<algorithm>{{ $d->algorithm }}</algorithm>
				<flags>{{ $d->flags }}</flags>
				<protocol>{{ $d->protocol }}</protocol>
				<publickey>{{ $d->key }}</publickey>
			</dnssec>
@endforeach
		</domain>
@endsection

