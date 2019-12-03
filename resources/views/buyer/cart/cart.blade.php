@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Cart</div>

                <div class="card-body">
                    <h3>Submit Cart</h3>
                    <hr>
                    <form method="POST" action="{{ route('storeOrderCart') }}">
                        @csrf
                    <div class="form-group row">
                        <div class="col-md-5">
                            <label for="bank">Bank</label>
                            <select name="bank_id" class="form-control">
                                @foreach($bank as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5">
                            <label for="address">Address Destination</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Product</th><th>Quantity</th><th>Price</th><th>Sub Price</th><th>Action</th>
                        </tr>
                   @foreach($product as $cart)
                        <tr>
                            <td>{{ $cart['name'] }}</td>
                            <td>{{ $cart['capacity'] }}</td>
                            <td>{{ $cart['price'] }}</td>
                            <td>{{ $cart['total_price'] }}</td>
                            <td><a href="/buyer/cart/editcapacity/{{ $cart['id'] }}" class="btn btn-warning btn-sm">Edit Capacity</a> | <a href="/buyer/cart/deletecapacity/{{ $cart['id'] }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete ?')">x</a> </td>
                        </tr>
                   @endforeach
                        <tr>
                            <td colspan="3">
                                Total Price
                            </td>
                            <td>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach($product as $i => $cart)
                                @php
                                 $total += $cart['total_price'];
                                @endphp
                                @endforeach
                                <input type="hidden" name="total_price" value="{{ $total }}">{{ $total }}
                            </td>
                            <td>
                                <input type="submit" name="submit" class="btn btn-primary" onclick="return confirm('Are you sure to order ?')">
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
