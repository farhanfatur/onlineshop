@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table" style="
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            ">
                <tr style="background-color: #eee;">
                    <th colspan="2"><span style="font-size: 18px;">Code: {{ $code }}</span></th>
                    <th><span style="font-size: 18px;">Quantity</span></th>
                    <th class="text-right" colspan="2"><span style="font-size: 18px;">Price</span></th>
                </tr>
                @foreach($orderitem as $data)
                <tr style="background-color: #fff;">
                    <td width="60">
                        <img src="{{ asset('storage/product/thumbnail/thumbnail_'.$data->product->image) }}">
                    </td>
                    <td>
                        <span style="font-size: 16px;">{{ $data->product->name }}</span>
                    </td>
                    <td>
                        <span style="font-size: 16px;">{{ $data->quantity }} items</span>
                    </td>
                    <td>
                        <span style="font-size: 16px;">Rp.</span>
                    </td>
                    <td class="text-right"><span style="font-size: 16px;">{{ number_rupiah($data->price) }}</span></td>
                </tr>
                @endforeach
                <tr style="background-color: #fff;">
                    <th colspan="3"><span style="font-size: 16px;">Total</span></th>
                    <td><span style="font-size: 16px;">Rp. </span></td>
                    <td class="text-right"><span style="font-size: 16px;">{{ number_rupiah($total_price) }}</span></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center"><i class="fas fa-info-circle"></i> Status: </h3>
                    @if($order->status_id == 1)
                    <h3 class="text-center">Upload Proof of Payment</h3>
                    <center><button class="btn btn-primary"  data-toggle="modal" data-target="#orderImage" onclick="showModal('{{ $order->imagepayment }}')">Upload</button></center>
                    @elseif($order->status_id == 2 && $order->imagepayment != null)
                    <div class="alert alert-danger text-center">
                        <span class="text-danger">The payment is send, please wait for confirmation</span>
                    </div>
                    @elseif($order->status_id == 3)
                    <div class="alert alert-warning text-center">
                        <span class="text-warning">Payment has been confirm by seller, is the product received ?<br>
                            <a href="/buyer/order/isreceive/{{ $order->id }}" onclick="return confirm('Are you sure?')">Yes</a> / <b>No</b></span>
                    </div>
                    @elseif($order->status_id == 4)
                    <div class="alert alert-success text-center">
                        <span class="text-success">Congratulation!!!, product has Receive</span>
                    </div>
                    @elseif($order->status_id == 5)
                    <div class="alert alert-danger text-center">
                        <span class="text-danger">You have cancel the order</span>
                    </div>
                    @elseif($order->status_id == 6)
                    <div class="alert alert-danger text-center">
                        <span class="text-danger">Seller is cancel the order</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($order->status_id == 1)
    <div class="row justify-content-center" style="margin-top: 5px;">
        <div class="col-md-12">
            <a href="/buyer/order/iscancel/{{ $order->id }}" class="btn btn-danger" onclick="return confirm('Do you want cancel it?')">X Cancel</a>
        </div>
    </div>
    @endif
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
