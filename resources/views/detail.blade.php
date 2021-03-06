@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @foreach($product as $data)
            <div class="card">
                <div class="card-header"><h4>{{ $data->name }}</h4></div>

                <div class="card-body">
                   <div class="row">
                      <div class="col-md-8">
                        @if($data->image != "" && file_exists('storage/product/'.$data->image))
                        <img src="{{ asset('storage/product/'.$data->image) }}">
                        @else
                        <img src="{{ asset('image/default.png') }}">
                        @endif
                      </div> 
                   </div>
                   <div class="row">
                       <div class="col-md-8">
                           <span>Stock : <b>{{ $data->quantity }}</b></span><br>
                           <span>Price: <b>Rp.{{ number_rupiah($data->price) }}</b></span><br>
                           <span>Category: <b>{{ $data->category->name }}</b></span>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-12">
                           <p>Description: <br>{{ $data->description }}</p>
                       </div>
                   </div>
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
                        <br>
                    <a href="/" class="btn btn-danger"> << Back</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
