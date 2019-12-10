@extends('layouts.app')

@section('content')
<div class="container">
    @if($exist = Session::get('sessionExist'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $exist }}</strong>
        </div>
    @endif

    @if($stock = Session::get('stockTooMuch'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $stock }}</strong>
        </div>
    @endif

    @if($message = Session::get('messageCart'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
        </div>
    @endif
    <div class="row">
        <div class="col-md-9">
            <h2>Our Product </h2>    
        </div> 
        <div class="col-md-3">
            <form method="GET" action="/search/product">
            <div class="input-group mb-3">
                <input type="text" name="searchtext" class="form-control" placeholder="Search by Product... ">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>  
            </div>
            </form>
        </div>
    </div>
    @if($searchtext != null)
        <span style="font-size: 16px;">Search Result : <b>{{ $searchtext }}</b></span>
    @endif
    <div class="row justify-content-left">
        <div class="col-md-9">
            @if(count($product) != 0)
            <div class="row">
                    
                @foreach($product as $data)
                <div class="col-md-4" style="margin-bottom: 5px;">
                    <div class="card">
                        @if(file_exists('storage/product/thumbnail/thumbnail_'.$data->image) && $data->image != "default.png" && $data->image != "")
                        <img src="{{ asset('storage/product/thumbnail/thumbnail_'.$data->image) }}" onclick="window.location.href='/detail/{{ $data->name_slug }}'" class="card-img-top" style="cursor: pointer;">
                        @else
                        <img src="{{ asset('image/thumbnail/thumbnail_default.png') }}" onclick="window.location.href='/detail/{{ $data->name_slug }}'" class="card-img-top" style="cursor: pointer;">
                        @endif
                        <div class="card-body" style="background-color: #fafafa;">
                            <h3>{{ $data->name }}</h3>
                            <table>
                                <tr>
                                    <td>Stock</td><td>:</td><th> 
                                    @if($data->quantity <= 0)
                                        <span>0</span>
                                    @else
                                    <b>{{ $data->quantity }}</b>
                                    @endif
                                    </th>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td>:</td>
                                    <th>Rp.{{ number_rupiah($data->price) }}</th>
                                </tr>
                                <tr>
                                    <td>Category</td>
                                    <td>:</td>
                                    <th>{{ $data->category->name }}</th>
                                </tr>
                            </table>
                                @if(auth()->guard('buyer')->user())
                                    @if($data->quantity > 0)
                                    <form method="POST" action="{{ route('storeCartBuyer') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                        <button class="btn btn-primary" type="submit">Add to Cart <i class="fas fa-cart-plus"></i></button>
                                    </form>
                                    @else
                                        <span class="text-danger">Product is empty</span>
                                    @endif
                                @else
                                <div class="alert alert-danger">
                                    <span class="text-danger">Can't add to cart, please login as buyer first</span>
                                </div>
                                @endif
                            
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-danger">
                <span class="text-danger"><h5 align="center">Product is empty</h5></span>
            </div>
            @endif
            {{ $product->links() }}
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Category</h5>
                    <ul class="list-group">
                    @foreach($category as $data)
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="/category/{{ $data->name }}">{{ $data->name }}</a>
                        <span class="badge badge-primary badge-pill">{{ count($data->product) }}</span>
                      </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
