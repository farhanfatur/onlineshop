@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Order</div>

                <div class="card-body">
                   @if($error = Session::get('dateError'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $error }}</strong>
                    </div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <td>No</td>
                            <th>Date Order</th>
                            <th>Product</th>
                            <th>Address Destination</th>
                            <th>Is Receive</th>
                            <th>Is Payment Receive</th>
                            <th>Is Shipped</th>
                            <th>Is Cancel</th>
                            <th>Image Payment Receive</th>
                            <th>Total Price</th>
                            <th>Date Shipped</th>
                            <th>Action</th>
                        </tr>                     
                        @php
                        $i = 1;
                        @endphp
                        @foreach($order as $data)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $data->dateorder }}</td>
                            <td>
                                @foreach($data->orderitem as $orderitem)
                                    <ul>
                                        <li>{{ $orderitem->product->name }} ({{ $orderitem->quantity }} item)</li>
                                    </ul>
                                @endforeach
                            </td>
                            <td>{{ $data->address }}</td>
                            <td>
                                @if($data->is_receive == '0')
                                    <span class="text-danger">Product is not receive</span>
                                @else
                                    <span class="text-success">Product is receive</span>
                                @endif
                            </td>
                            <td>
                                @if($data->is_paymentfrombuyer == '0' || $data->imagepayment == null)
                                    <span class="text-danger">You have not made payment</span>
                                @else
                                    @if($data->is_paymentreceive == '1')
                                        <span class="text-success">Your payment receive are confirm</span>
                                    @else
                                        <span class="text-success">Your payment receive are send</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($data->cancelfrombuyer == '0' && $data->is_cancel == '1')
                                    <span class="text-danger">Seller is cancel your order</span>
                                @else
                                    @if($data->is_shipped == '0')
                                        <a href="/buyer/order/isshipped/{{ $data->id }}" onclick="return confirm('Are you sure the product is shipped ?')">Yes</a> / <b>No</b>
                                    @else
                                        <b>Yes</b> / <a href="/buyer/order/isnotshipped/{{ $data->id }}" onclick="return confirm('Are you sure about that ?')">No</a>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($data->is_shipped == '0')
                                    @if($data->cancelfrombuyer == null && $data->is_cancel == '0')
                                        <a href="/buyer/order/iscancel/{{ $data->id }}" onclick="return confirm('Do you want cancel?')">Yes</a> / <b>No</b>
                                    @elseif($data->cancelfrombuyer == '1' && $data->is_cancel == '1')
                                        <span class="text-danger">Your order is cancel, want return back ?</span><br>
                                            <b>Yes</b> / <a href="/buyer/order/iscancel/{{ $data->id }}/return" onclick="return confirm('Do you want return back?')">No</a>
                                    @elseif($data->cancelfrombuyer == '0' && $data->is_cancel == '1')
                                        <span class="text-danger">Seller is cancel your order</span>
                                    @elseif($data->cancelfrombuyer == '0' && $data->is_cancel == '0')
                                        <a href="/buyer/order/iscancel/{{ $data->id }}" onclick="return confirm('Do you want cancel?')">Yes</a> / <b>No</b>
                                    @endif
                                @else
                                    <span class="text-success">Data is shipped</span>
                                @endif
                            </td>
                            <td>
                                @if($data->imagepayment == null)
                                <span class="text-danger">You dont't have payment</span>
                                @else
                                <span class="text-success">You have payment</span>
                                @endif
                            </td>
                            <td>
                                Rp.{{ $data->total_price }}
                            </td>
                            <td>
                                {{ $data->dateshipped }}
                            </td>
                            <td>
                                @if($data->cancelfrombuyer == '0' && $data->is_cancel == '1')
                                    <span class="text-danger">You can't order because seller is cancel</span>
                                @else
                                <a href="/buyer/order/imagepayment/{{ $data->id }}" class="btn btn-warning">Upload Image Payment</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
