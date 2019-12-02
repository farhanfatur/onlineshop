@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Staff</div>

                <div class="card-body">
                    <button class="btn btn-primary" onclick="window.location.href='/seller/staff/add'">+ Add Staff</button>
                   
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
                            <td><a href="/seller/staff/edit/{{ $data->id }}">Edit</a> | <a href="/seller/staff/delete/{{ $data->id }}" onclick="return confirm('Are you sure to delete this?')">Delete</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
