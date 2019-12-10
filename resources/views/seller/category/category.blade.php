@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fas fa-archive"></i> Category</div>

                <div class="card-body">
                    <button class="btn btn-primary" onclick="window.location.href='/seller/category/add'"><i class="fas fa-archive"></i> Add Category</button>
                    <table class="table table-bordered">
                        @php
                        $i = 1
                        @endphp
                        <tr>
                            <th>No</th><th>Name</th><th>Action</th>
                        </tr>
                        @foreach($category as $data) 
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$data->name}}</td>
                            <td><a href="/seller/category/edit/{{ $data->id }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> | <a href="/seller/category/delete/{{ $data->id }}" onclick="return confirm('Are you sure to delete this category ?')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
