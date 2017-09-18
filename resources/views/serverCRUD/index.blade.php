@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>All DNS servers</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('serverCRUD.create') }}"> Create New DNS Server</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>IP</th>
            <th width="280px">Action</th>
        </tr>

    @foreach ($items as $key => $item)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->ip }}</td>
        <td>
            <a class="btn btn-info" href="{{ route('serverCRUD.show',$item->id) }}">Show</a>
            <a class="btn btn-primary" href="{{ route('serverCRUD.edit',$item->id) }}">Edit</a>
            <a class="btn btn-danger" onclick="return confirm('Are you sure?')" href="{{ route('serverCRUD.destroy',$item->id) }}">Delete</a>
        </td>
    </tr>
    @endforeach
    </table>

    {!! $items->render() !!}

</div>
@endsection
