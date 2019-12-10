@extends('layouts.app')

@section('content')
<div class="container">
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
                            <td>Code</td>
                            <th>Product</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>                     
                        @php
                        $i = 1;
                        @endphp
                        @foreach($order as $data)
                        <tr>
                            <td>{{ $data->code }}</td>
                            <td>
                                @foreach($data->orderitem as $orderitem)
                                    <ul>
                                        <li>{{ $orderitem->product->name }} ({{ $orderitem->quantity }} item)</li>
                                    </ul>
                                @endforeach
                            </td>
                            <td>
                                Rp.{{ number_rupiah($data->total_price) }}
                            </td>
                            <td>
                                <h5><span class="badge badge-secondary badge-xl">ads</span></h5>
                            </td>
                            <td>
                                <a href="/buyer/order/detail/{{ $data->id }}" class="btn btn-warning">Status</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection
