@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h4>Detail Order</h4></div>

                <div class="card-body">
                   
                    <table class="table table-bordered">
                        <tr>
                            <th>Code</th>
                            <th>Buyer</th>
                            <th>Product</th>
                            <th>Address</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach($order as $data)
                        <tr>
                            <td>{{ $data->code }}</td>
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
                                @if($data->status_id == 1)
                                <h5><span class="badge badge-danger badge-xl">Unpaid</span></h5>
                                @elseif($data->status_id == 2 && $data->imagepayment == null)
                                <h5><span class="badge badge-danger badge-xl">Imagepayment null</span></h5>
                                @elseif($data->status_id == 2 && $data->imagepayment != null)
                                <h5><span class="badge badge-success badge-xl">Paid</span></h5>
                                @elseif($data->status_id == 3)
                                <h5><span class="badge badge-success badge-xl">Send</span></h5>
                                @elseif($data->status_id == 4)
                                <h5><span class="badge badge-success badge-xl">Receive</span></h5>
                                @elseif($data->status_id == 5)
                                <h5><span class="badge badge-danger badge-xl">Cancel by buyer</span></h5>
                                @elseif($data->status_id == 6)
                               <h5><span class="badge badge-danger badge-xl">Cancel by seller</span></h5>
                                @endif
                            </td>
                            <td>
                                <a href="/seller/order/detail/{{ $data->id }}" class="btn btn-warning">Status</a>
                            </td>                            
                        </tr>
                        @endforeach                   
                    </table>
                </div>
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
