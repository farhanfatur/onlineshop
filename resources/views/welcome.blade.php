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

    @if($warning = Session::get('warning'))
        <div class="alert alert-warning alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $warning }}</strong>
        </div>
    @endif
    <div class="row justify-content-center">
        @foreach($product as $data)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h3><a href="/detail/{{ $data->name_slug }}">{{ $data->name }}</a></h3></div>

                <div class="card-body">
                    <img src="{{ asset('storage/product/'.$data->image) }}" class="card-img">
                    <p>
                        <span>Stock : <b>{{ $data->quantity }}</b></span><br>
                        <span>Price: <b>Rp.{{ $data->price }}</b></span><br>
                        <span>Category: <b>{{ $data->category->name }}</b></span>
                    </p>
                        @if(auth()->guard('buyer')->user())
                            @if($data->quantity > 0)
                            <form method="POST" action="{{ route('storeCartBuyer') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <input type="number" name="capacity" >
                                <button class="btn btn-primary" type="submit">Add to Cart</button>
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
</div>
@endsection
