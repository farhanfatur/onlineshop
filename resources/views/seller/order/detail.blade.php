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

                    <div class="alert alert-danger text-center">
                        <i class="fas fa-times" style="font-size: 18px;"></i><br>
                        <span class="text-danger">The buyer has not paid</span>
                    </div>

                    @elseif($order->status_id == 2 && $order->imagepayment == null)

                    <div class="alert alert-danger text-center">
                        <i class="fas fa-times" style="font-size: 18px;"></i><br>
                        <span class="text-danger">The buyer doesn't have payment</span>
                    </div>

                    @elseif($order->status_id == 2 && $order->imagepayment != null)

                    <center><button class="btn btn-primary"  data-toggle="modal" data-target="#paymentImage" onclick="showModal('{{ $order->imagepayment }}')">Show Payment</button></center>
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-question-circle" style="font-size: 18px;"></i><br>
                        <span class="text-warning">The buyer has been payment, do you want confirm ?<br>
                            <a href="/seller/order/shipped/active/{{ $order->id }}" onclick="return confirm('Are you sure?')">Yes</a> / <b>No</b>
                        </span>
                    </div>

                    @elseif($order->status_id == 3)

                    <div class="alert alert-success text-center">
                        <i class="fas fa-check" style="font-size: 18px;"></i><br>
                        <span class="text-success">Product has been send, please wait product are receive by buyer</span>
                    </div>

                    @elseif($order->status_id == 4)

                    <div class="alert alert-success text-center">
                        <i class="fas fa-check" style="font-size: 18px;"></i><br>
                        <span class="text-success">Congratulation!!!, buyer has receive the product</span>
                    </div>

                    @elseif($order->status_id == 5)

                    <div class="alert alert-danger text-center">
                        <i class="fas fa-times" style="font-size: 18px;"></i><br>
                        <span class="text-danger">Buyer has cancel a order</span>
                    </div>

                    @elseif($order->status_id == 6)

                    <div class="alert alert-danger text-center">
                        <i class="fas fa-times" style="font-size: 18px;"></i><br>
                        <span class="text-danger">You cancel the order</span>
                    </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($order->status_id == 1)
    <div class="row justify-content-center" style="margin-top: 5px;">
        <div class="col-md-12">
            <a href="/seller/order/cancel/active/{{ $order->id }}" class="btn btn-danger" onclick="return confirm('Do you want cancel it?')">X Cancel</a>
        </div>
    </div>
    @endif
</div>

<div class="modal fade" id="paymentImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Image Payment</h5>
                        </div>
                        <div class="modal-body">
                            <img id="imagepayment">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
            </div>
        </div>
        <script type="text/javascript">
            function showModal(image) {
                $("#imagepayment").attr('src', '{{ asset("storage/buyer") }}/'+image);
            }
        </script>
@endsection
