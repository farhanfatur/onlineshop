@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Product</div>

                <div class="card-body">
                    <button class="btn btn-primary" onclick="window.location.href='/seller/product/add'"><i class="fas fa-box"></i> Add Product</button>
                   
                    <table class="table table-bordered">
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Activation</th>
                            <th>Action</th>
                        </tr>
                       
                        @foreach($product as $data)
                        <tr>
                            <td>{{ $data->code }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->quantity }}</td>
                            <td>{{ $data->category->name }}</td>
                            <td>Rp. {{ number_rupiah($data->price) }}</td>
                            <td>
                                @if($data->is_sold == '0')
                                <a href="/seller/product/active/{{ $data->id }}" class="text-success"><i class="fas fa-check"></i></a> | <b><i class="fas fa-times"></i></b>
                                @else
                                <b><i class="fas fa-check"></i></b> | <a href="/seller/product/deactive/{{ $data->id }}" class="text-danger"><i class="fas fa-times"></i></a>
                                @endif
                            </td>
                            <td><a href="/seller/product/edit/{{ $data->id }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> | <a href="/seller/product/delete/{{ $data->id }}" onclick="return confirm('Are you sure to delete this?')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
