@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Show DNS server</div>

                <div class="panel-body">
		    <div class="pull-right">
			<a class="btn btn-primary" href="{{ route('serverCRUD.index') }}"> Back</a>
		    </div>

			<div class="col-xs-12 col-sm-12 col-md-12">
			    <div class="form-group">
				<strong>Name:</strong>
				{{ $item->name }}
			    </div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12">
			    <div class="form-group">
				<strong>IP:</strong>
				{{ $item->ip }}
			    </div>
			</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
