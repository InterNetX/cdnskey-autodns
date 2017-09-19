@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update DNS zone</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('zoneCRUD.update', ['zoneCRUD' => $item->id ]) }}">
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

                        <div class="form-group{{ $errors->has('dns_server_id') ? ' has-error' : '' }}">
                            <label for="dns_server_id" class="col-md-4 control-label">Server</label>

                            <div class="col-md-6">
				<select id="dns_server_id" name="dns_server_id">
					@foreach ($servers as $server)
                                	<option value="{{ $server->id }}" {{ old('dns_server_id') == $server->id ? 'selected' : '' }}>{{ $server->name }} ({{ $server->ip }})"</option>
					@endforeach
				</select>

                                @if ($errors->has('dns_server_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dns_server_id') }}</strong>
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
