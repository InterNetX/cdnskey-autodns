@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p><a href="{{ route('serverCRUD.index') }}">Manage DNS Servers</a></p>
                    <p><a href="{{ route('zoneCRUD.index') }}">Manage Zones</a></p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
