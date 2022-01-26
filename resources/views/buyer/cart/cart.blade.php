@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Cart</div>

                <div class="card-body">
                    @if($product != null)
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
                        <div class="col-md-6">
                            <label for="province">Province</label>
                            <select name="province_id" id="province_id" class="form-control" onchange="selectCity(this.value)">
                                <option value="">--- Province ---</option>
                                @foreach($province as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="city">City</label>
                            <select name="city_id" id="city_id" class="form-control" onchange="getOngkir(this.value, 'city')" disabled>
                                <option value="">--- City ---</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="bank">Bank</label>
                            <select name="bank_id" id="bank_id" class="form-control" {{count($bank) > 0 ? '' : 'disabled'}}>
                                @if(count($bank) > 0)
                                    @foreach($bank as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                @else
                                    <option value="">--- No Bank ---</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="address">Address Destination</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label for="bank">Courier</label>
                            <select name="courier_id" id="courier_id" class="form-control" onchange="getOngkir(this.value, 'courier')" {{count($courier) > 0 ? '' : 'disabled'}} >
                                @if(count($courier) > 0)
                                    <option value="">--- Courier ---</option>
                                    @foreach($courier as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                @else
                                    <option value="">--- No Courier ---</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <!-- Ongkir table -->
                    <div class="row">
                        <div id="titleOngkir"></div>
                    </div>
                    <!-- courier list -->
                    <div class="row">
                        <div class="col-md-12">
                            <div id="courierList"></div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th></th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Sub Price</th>
                            <th>Action</th>
                        </tr>
                        @foreach($product as $cart)
                        <tr>
                            <td>
                                <input type="checkbox" name="check[{{ $cart['id'] }}]" id="check_{{ $cart['id'] }}" 
                                @if($cart['capacity'] != 0) checked @endif onclick="checkedProduct('{{ $cart['id'] }}', this)">
                            </td>
                            <td>{{ $cart['name'] }}</td>
                            <td>
                                <input type="number" name="quantity[{{ $cart['id'] }}]" id="quantity_{{ $cart['id'] }}" value="{{ $cart['capacity'] }}" min="0" style="width: 50px;" max="5" onchange="changeQuantity('{{ $cart['id'] }}', '{{ $cart['weight'] }}')">
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
                    @else
                    <tr>
                        <td colspan="6">
                            <div class="alert alert-danger">
                                <div class="row">
                                    <div class="col-md-9">
                                        <span class="text-danger">Order Product can't empty</span>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/" class="btn btn-danger">Back to Home</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        // var data
        var couriers = []
        var cities = []
        var ongkir = {
            destination: 0,
            courier: 0,
            bank: 0
        }

        function getCourier(data)
        {
            $("#courierList").empty()
            $("#titleOngkir").empty()
            $("#titleOngkir").append($(`<div class="col-md-12">
                            <h4>Ongkir</h4>
                            <hr>
                        </div>`))
            $.each(data, function(i, item) {
                var val = JSON.stringify(item)

                $("#courierList").append($(`
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="typeCourier" id="typeCourier${item.service}" onchange='countCourierTotal(${val})'>
                                <label class="form-check-label" for="typeCourier${item.service}">${item.service}(${item.description}) / ${item.cost[0].etd} days | Rp.<span id="cost">${item.cost[0].value}</span></label>
                            </div>
                `))
                // var cost = parseInt($("#cost").text())
                // $("#cost").text((cost/1000).toFixed(3))
            })
        }

        function countCourierTotal(val)
        {
            var total = parseInt($("#total_price_hidden").val())
            var cost = val.cost[0].value
            var totalCost = total + cost

            $("#total_price_hidden").val(totalCost)
            $("#total_price").text((totalCost/1000).toFixed(3))
            cost = 0
            totalCost = 0
        }

        function selectCity(id)
        {
            var idProvince = id
            if(idProvince != "") {
                $.ajax({
                    url: "cart/getcity/"+idProvince,
                    method: "POST",
                    data: {
                        '_token': $("[name=csrf-token]").attr('content'),
                    },
                    dataType: 'json',
                    success: function(data) {
                        cities = data
                        $("#city_id").removeAttr("disabled")
                        
                        retreiveCity(cities)
                    },
                    
                })
            }
        }

        function getOngkir(val, type = "city")
        {
            if(type == "courier") {
                ongkir.courier = val
            }else {
                ongkir.destination = val
            }

            if(ongkir.courier > 0 && ongkir.destination > 0) {
                $.ajax({
                    url: "cart/getongkir",
                    method: "POST",
                    data: {
                        '_token': $("[name=csrf-token]").attr('content'),
                        'courier': ongkir.courier,
                        'destination': ongkir.destination
                    },
                    dataType: "json",
                    success: function(data) {
                        couriers = data.costs
                        
                        getCourier(couriers)
                    }
                })
            }
        }

        function retreiveCity(data)
        {
            $("#city_id option").remove()
            $.each(data, function(i, item) {
                if(i == 0) {
                    getOngkir(item.id, "city")
                }
                $("#city_id").append($("<option>", {
                    value: item.id,
                    text: item.type + " " + item.city_name,
                }))
            })
        }
        
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

        function changeQuantity(id, weight)
        {
            var quantity = $("#quantity_"+id).val()
            if(quantity == 0) {
                $("#check_"+id).prop('checked', false)
                $("#quantity_"+id).val(0)
                $("#price_"+id).text(0)
                $("#sub_price_"+id).text(0)
                countCart(id, 0, false, weight)
            }else {
               countCart(id, quantity, true, weight)
            }
        }


        function countCart(id, quantity, boolProduct = true, weight)
        {
            $.ajax({
                url: "{{ route('editQuantity') }}",
                method: "POST",
                data: {
                    '_token': $("[name=csrf-token]").attr('content'),
                    'id': id,
                    'quantity': quantity,
                    'weight': weight
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
