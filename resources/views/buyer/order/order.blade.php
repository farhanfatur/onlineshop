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
                            <th>Is Payment Receive</th>
                            <th>Is Receive</th>
                            <th>Is Cancel</th>                            
                            <th>Total Price</th>
                            <th>Date Receive</th>
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
                                @if($data->status_id == 5 || $data->status_id == 6)
                                    <span class="text-danger">The order has been canceld</span>
                                @else
                                    @if($data->imagepayment == null)
                                        <p class="text-danger">You haven't pay for produck</p>
                                        <button class="btn btn-warning" onclick="showModal('{{ $data->id }}')" data-toggle="modal" data-target="#orderImage">Upload Payment</button>
                                    @else
                                        <span class="success">You already for paid the product</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($data->status_id == 6 || $data->status_id == 5)
                                    <span class="text-danger">The order has been canceled</span>
                                @else
                                    @if($data->status_id >= 3 && $data->status_id < 4)
                                        <div class="alert alert-danger">
                                            <span class="text-danger">Is the product receive?</span><br>
                                            <a href="/buyer/order/isreceive/{{ $data->id }}" class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')">Yes</a>
                                        </div>
                                    @elseif($data->status_id == 4)
                                        <span class="text-success">Congratulation!! Your product is receive</span>
                                    @else
                                        <span class="text-danger">Please wait a minute for receive</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($data->status_id == 4)
                                    <span class="text-success">Can't cancel because product has been receive</span>
                                @else
                                    @if($data->imagepayment != "" && $data->status_id >= 2 && $data->status_id <= 4)
                                        <span class="text-success">You have ready the payment</span>
                                    @else
                                        @if($data->status_id == 1)
                                            <a href="/buyer/order/iscancel/{{ $data->id }}" onclick="return confirm('Do you want cancel?')">Yes</a> / <b>No</b>
                                        @else
                                            <b>Yes</b> / <a href="/buyer/order/iscancel/{{$data->id}}/return" onclick="return confirm('Do you want return?')">No</a>
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td>
                                Rp.{{ number_rupiah($data->total_price) }}
                            </td>
                            <td>
                                {{ $data->datereceive }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="orderImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="POST" action="{{ route('storeImagePayment') }}" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Upload Image</h5>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <label>Choose Image</label>
                            <div class="form-group">
                                <input type="file" name="imagepayment" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            function showModal(id) {
                $("#id").val(id);
            }
        </script>
@endsection
