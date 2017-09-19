@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit DNS server</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('serverCRUD.update', ['serverCRUD' => $item->id ]) }}">
                        {{ csrf_field() }}
			{{ method_field('PUT') }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $item->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('ip') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">IP</label>

                            <div class="col-md-6">
                                <input id="ip" type="text" class="form-control" name="ip" value="{{ $item->ip }}" required>

                                @if ($errors->has('ip'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ip') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
