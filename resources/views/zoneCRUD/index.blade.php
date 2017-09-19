@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>All DNS zones</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('zoneCRUD.create') }}"> Create New DNS Zone</a>
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
            <th>DNS-Server</th>
            <th width="280px">Action</th>
        </tr>

    @foreach ($items as $key => $item)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->server->name }} ({{ $item->server->ip }})</td>
        <td>
            <a class="btn btn-info" href="{{ route('zoneCRUD.show',$item->id) }}">Show</a>
            <a class="btn btn-primary" href="{{ route('zoneCRUD.edit',$item->id) }}">Edit</a>
            <a class="btn btn-danger" onclick="event.preventDefault(); if(confirm('Do you really want to delete this DNS zone?')) document.getElementById('delete-form').submit();" href="{{ route('zoneCRUD.destroy',$item->id) }}">Delete</a>
            <form id="delete-form" action="{{ route('zoneCRUD.destroy',$item->id) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
		{{ method_field('DELETE') }}
            </form>
        </td>
    </tr>
    @endforeach
    </table>

    {!! $items->render() !!}

</div>
@endsection
