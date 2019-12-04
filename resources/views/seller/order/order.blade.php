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
                            <th>Date Receive</th>
                            <th>Buyer</th>
                            <th>Product</th>
                            <th>Address</th>
                            <th>Total Price</th>
                            <th>Is Payment Receive</th>
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
                            <td>
                                @if($data->datereceive == null)
                                    <span class="text-danger">the product is not receive</span>
                                @else
                                    <span class="text-success">the product is receive</span>
                                @endif
                                </td>
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
                                Rp.{{ number_rupiah($data->total_price) }}
                            </td>
                            <td>
                                @if($data->status_id < '2')
                                    <span class="text-danger">{{$data->buyer->name}} have not made payment</span>
                                @else
                                    @if($data->status_id >= '2' && $data->status_id <= '4')
                                        <span class="text-success">Payment Receive is send</span><br>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#orderPaymentImage" onclick="showPaymentImage('{{ $data->imagepayment }}')">Show Image</button>
                                    @elseif($data->status_id == '1')
                                        <span class="text-danger">Buyer isn't paid</span>
                                    @else
                                        <span class="text-danger">The order has been canceled</span>
                                    @endif
                                @endif
                            </td>
                            <td>

                               @if($data->status_id == 2)
                                    <a href="/seller/order/shipped/active/{{ $data->id }}">Yes</a> / <b>No</b>
                               @elseif($data->status_id == 1)
                                    <span class="text-danger">{{$data->buyer->name}} have not made payment</span>
                                @elseif($data->status_id >= 5 && $data->status_id <= 6)
                                    <span class="text-danger">The order has been canceled</span>
                                @else
                                    <span class="text-success">The product is shipped</span>
                               @endif
                            </th>
                            <td>
                                @if($data->status_id == 4)
                                    <span class="text-success">The order is success</span>
                                @elseif($data->status_id == 3)
                                    <span class="text-success">Wait for order arrived </span>
                                @else
                                    @if($data->status_id >= 1 && $data->status_id <= 4)
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

    <div class="modal fade" id="orderPaymentImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
               
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Image Payment</h5>
                        </div>
                        <div class="modal-body">
                           <img id="imagePayment" class="modal-content">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                
            </div>
        </div>
    <script type="text/javascript">
        function showPaymentImage(imageName) {
            $("#imagePayment").attr("src", "{{ asset('storage/buyer/') }}"+"/"+imageName)
        }
    </script>
@endsection
