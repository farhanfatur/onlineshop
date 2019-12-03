@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach($product as $data)
            <div class="card">
                <div class="card-header"><h4>{{ $data->name }}</h4></div>

                <div class="card-body">
                   <div class="row">
                      <div class="col-md-8">
                          <img src="{{ asset('storage/product/'.$data->image) }}">
                      </div> 
                   </div>
                   <div class="row">
                       <div class="col-md-8">
                           <span>Stock : <b>{{ $data->quantity }}</b></span><br>
                           <span>Price: <b>Rp.{{ $data->price }}</b></span><br>
                           <span>Category: <b>{{ $data->category->name }}</b></span>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-12">
                           <p>{{ $data->description }}</p>
                       </div>
                   </div>
                   @if(auth()->guard('buyer')->user())
                            @if($data->capacity > 0)
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
                    <button class="btn btn-default" onclick="window.location.href='/'"> << Back</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
