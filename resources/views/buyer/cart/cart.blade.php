@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
                            <th></th><th>Product</th><th>Quantity</th><th>Price</th><th>Sub Price</th><th>Action</th>
                        </tr>
                    @if($product != null)
                   @foreach($product as $cart)
                        <tr>
                            <td>
                                <input type="checkbox" name="check[{{ $cart['id'] }}]" id="check_{{ $cart['id'] }}" 
                                @if($cart['capacity'] != 0) checked @endif onclick="checkedProduct('{{ $cart['id'] }}', this)">
                            </td>
                            <td>{{ $cart['name'] }}</td>
                            <td>
                                <input type="number" name="quantity[{{ $cart['id'] }}]" id="quantity_{{ $cart['id'] }}" value="{{ $cart['capacity'] }}" min="0" style="width: 50px;" max="5" onchange="changeQuantity('{{ $cart['id'] }}')">
                            </td>
                            <td>Rp. <span id="price_{{ $cart['id'] }}">
                                @if($cart['capacity'] == 0)
                                0
                                @else
                                {{ number_rupiah($cart['price']) }}
                                @endif
                            </span>
                            </td>
                            <td>Rp. <span id="sub_price_{{ $cart['id'] }}">{{ number_rupiah($cart['total_price']) }}</span></td>
                            <td>
                             <a href="/buyer/cart/deletecapacity/{{ $cart['id'] }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete ?')">x</a> </td>
                        </tr>
                   @endforeach
                    @else
                    <tr>
                        <td colspan="6">
                            <div class="alert alert-danger">
                                <div class="row">
                                    <div class="col-md-9">
                                        <span class="text-danger">Order Product is empty</span>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/" class="btn btn-danger">Back to Home</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif
                        <tr>
                            <td colspan="4">
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
</div>
    <script type="text/javascript">
        var data
        function checkedProduct(id, data)
        {
            if(data.checked == false) {
                $("#quantity_"+id).val(0)
                $("#price_"+id).text(0)
                $("#sub_price_"+id).text(0)
                var quantity = $("#quantity_"+id).val()
                countCart(id, quantity, data.checked)
            }else {
                countCart(id, 1, data.checked)
            }
        }
        function changeQuantity(id)
        {
            var quantity = $("#quantity_"+id).val()
            if(quantity == 0) {
                $("#check_"+id).prop('checked', false)
                $("#quantity_"+id).val(0)
                $("#price_"+id).text(0)
                $("#sub_price_"+id).text(0)
                countCart(id, 0, false)
            }else {
               countCart(id, quantity, true)
            }
        }


        function countCart(id, quantity, boolProduct = true)
        {
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
                                if(boolProduct == true) {
                                    $("#price_"+id).text(number_rupiah(val.price))
                                }
                                $("#sub_price_"+val.id).text(number_rupiah(val.total_price))  
                            }
                            totalPrice += val.total_price
                        });
                        if($("#check_"+id).is(":checked") == false && quantity != 0) {
                            $("#check_"+id).prop('checked', true)
                        }
                        $("#total_price_hidden").val(totalPrice)
                        $("#total_price").text(number_rupiah(totalPrice))
                    }
                    
                },
                error: function (data, status) {
                    console.log(data, status)
                }
            })
        }
    </script>
@endsection
