@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Product</div>

                <div class="card-body">
                    <button class="btn btn-primary" onclick="window.location.href='/seller/product/add'">+ Add Product</button>
                   
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Activation</th>
                            <th>Action</th>
                        </tr>
                        @php
                        $i = 1
                        @endphp
                        @foreach($product as $data)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->quantity }}</td>
                            <td>{{ $data->category->name }}</td>
                            <td>{{ $data->price }}</td>
                            <td>
                                @if($data->is_sold == '0')
                                <a href="/seller/product/active/{{ $data->id }}">Active</a> / <b>Deactive</b>
                                @else
                                <b>Active</b> / <a href="/seller/product/deactive/{{ $data->id }}">Deactive</a>
                                @endif
                            </td>
                            <td><a href="/seller/product/edit/{{ $data->id }}">Edit</a> | <a href="/seller/product/delete/{{ $data->id }}" onclick="return confirm('Are you sure to delete this?')">Delete</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
