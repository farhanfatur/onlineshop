@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Cart</div>

                <div class="card-body">
                    <h3>Submit Cart</h3>
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                     {{$errors->first()}}
                    </div>
                    @endif
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
                    @if($product != null)
                   @foreach($product as $cart)
                        <tr>
                            <td>{{ $cart['name'] }}</td>
                            <td>
                                <input type="number" name="quantity" id="quantity_{{ $cart['id'] }}" value="{{ $cart['capacity'] }}" min="1" style="width: 50px;" max="5" onchange="changeQuantity('{{ $cart['id'] }}')">
                            </td>
                            <td>Rp. {{ number_rupiah($cart['price']) }}</td>
                            <td>Rp. <span id="sub_price_{{ $cart['id'] }}">{{ number_rupiah($cart['total_price']) }}</span></td>
                            <td>
                             <a href="/buyer/cart/deletecapacity/{{ $cart['id'] }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete ?')">x</a> </td>
                        </tr>
                   @endforeach
                    @else
                    <tr>
                        <td colspan="5"><span class="text-danger"><center>Order Product is empty</center></span></td>
                    </tr>
                    @endif
                        <tr>
                            <td colspan="3">
                                Total Price
                            </td>
                            <td>
                                @if($product != null)
                                @php
                                    $total = 0;
                                @endphp
                                @foreach($product as $i => $cart)
                                @php
                                 $total += $cart['total_price'];
                                @endphp
                                @endforeach
                                <input type="hidden" name="total_price" id="total_price_hidden" value="{{ $total }}">Rp. <span id="total_price">{{ number_rupiah($total) }}</span>
                                @else
                                Rp. 0
                                @endif
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
    <script type="text/javascript">
        function changeQuantity(id)
        {
            var quantity = $("#quantity_"+id).val()
            if(quantity == 0) {
                alert('Quantity is not 0 or empty')
                $("#quantity_"+id).val(1)
            }else {
                $.ajax({
                    url: "{{ route('editQuantity') }}",
                    method: "POST",
                    data: {
                        '_token': $("[name=csrf-token]").attr('content'),
                        'id': id,
                        'quantity': quantity,
                    },
                    dataType: 'json',
                    success: function (data, status) {
                        if(data.error) {
                            alert(data.error)
                            $("#quantity_"+id).val(data.quantity)
                        }else {
                            var totalPrice = 0
                            $.each(data, function(i, val) {
                                if(val.id == id) {
                                    $("#quantity_"+val.id).val(val.capacity)
                                    $("#sub_price_"+val.id).text(number_rupiah(val.total_price))  
                                }
                                totalPrice += val.total_price
                            });
                            // console.log(totalPrice)
                            // $("#total_price").text('');
                            $("#total_price_hidden").val(totalPrice)
                            $("#total_price").text(number_rupiah(totalPrice))
                        }
                        
                    },
                    error: function (data, status) {
                        console.log(data, status)
                    }
                })
            }
        }
    </script>
@endsection
