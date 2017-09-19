@extends('autodns')
@section('task')
		<code>{{ $function_code }}</code>
		<domain>
			<name>{{ $name }}</name>
@foreach ($ns as $n)
			<nserver>
				<name>{{ $n->nsdname }}</name>
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

