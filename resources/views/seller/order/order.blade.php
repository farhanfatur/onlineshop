@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Order</div>

                <div class="card-body">
                   
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Date Order</th>
                            <th>Date Shipped</th>
                            <th>Buyer</th>
                            <th>Product</th>
                            <th>Address</th>
                            <th>Total Price</th>
                            <th>Is Payment Receive</th>
                            <th>Is Receive</th>
                            <th>Is Shipped</th>
                            <th>Is Cancel</th>
                        </tr>
                        @php
                        $i = 1;
                        @endphp
                        @foreach($order as $data)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $data->dateorder }}</td>
                            <td>{{ $data->dateshipped }}</td>
                            <td>{{ $data->buyer->name }}</td>
                            <td>
                                <ul>
                                @foreach($data->orderitem  as $orderitem)
                                    
                                        <li>{{ $orderitem->product->name }} ({{ $orderitem->quantity }} item)</li>
                                    
                                @endforeach
                                </ul>
                            </td>
                            <td>{{ $data->address }}</td>
                            <td>
                                {{ $data->total_price }}
                            </td>
                            <td>
                                @if($data->is_paymentfrombuyer == '0' || $data->imagepayment == null)
                                    <span class="text-danger">{{$data->buyer->name}} have not made payment</span>
                                @else
                                    @if($data->is_paymentreceive == '0')
                                    <span class="text-success">{{$data->buyer->name}} is send payment receive, want a confirm payment ?</span><br>
                                        <a href="/seller/order/paymentreceive/active/{{ $data->id }}">Yes</a> / <b>No</b>
                                    @else
                                        <span class="text-success">Payment Receive is confirm</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($data->is_paymentreceive == '1')
                                    @if($data->is_receive == '0')
                                        <a href="/seller/order/receive/active/{{ $data->id }}" onclick="return confirm('Do you want receive ?')">Active</a> / <b>Deactive</b>
                                    @else
                                        <b>Active</b> / <a href="/seller/order/receive/deactive/{{ $data->id }}">Deactive</a>
                                    @endif
                                @else
                                    <span class="text-danger">Confirm a payment receive first</span>
                                @endif
                            </td>
                            <td>
                                @if($data->is_shipped == '0')
                                <span class="text-danger">Product is not shipped</span>
                                @else
                                <span class="text-success">Product is shipped</span>
                                @endif
                            </th>
                            <td>
                                @if($data->is_receive == '1' && $data->is_paymentreceive == '1' && $data->is_paymentfrombuyer == '1' && $data->is_shipped == '1')
                                    <span class="text-success">The order is success</span>
                                @else
                                    @if($data->is_cancel == '0')
                                    <a href="/seller/order/cancel/active/{{ $data->id }}" onclick="return confirm('Do you want cancel this order?')">Active</a> / <b>Deactive</b>
                                    @else
                                    <b>Active</b> / <a href="/seller/order/cancel/deactive/{{ $data->id }}" onclick="return confirm('Want return back?')">Deactive</a>
                                    @endif
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
