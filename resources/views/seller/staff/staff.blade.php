@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Staff</div>

                <div class="card-body">
                    <button class="btn btn-primary" onclick="window.location.href='/seller/staff/add'"><i class="fas fa-users"></i> Add Staff</button>
                   
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Date Birth</th>
                            <th>Action</th>
                        </tr>
                        @php
                        $i = 1;
                        @endphp
                        @foreach($staff as $data)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->address }}</td>
                            <td>{{ $data->phone }}</td>
                            <td>{{ $data->datebirth }}</td>
                            <td><a href="/seller/staff/edit/{{ $data->id }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> | <a href="/seller/staff/delete/{{ $data->id }}" onclick="return confirm('Are you sure to delete this?')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
