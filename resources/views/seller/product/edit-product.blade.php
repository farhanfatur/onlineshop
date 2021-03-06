@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fas fa-box"></i> Edit Product</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('updateProduct') }}" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" name="id" value="{{ $product->id }}">
                       <div class="form-group row">
                           <div class="col-md-8">
                               <label for="name"><i class="fas fa-user-alt"></i> Name</label>
                               <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $product->name }}">
                               @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>
                       </div>
                       <div class="form-group row">
                           <div class="col-md-4">
                               <label for="capacity"><i class="fas fa-sort-numeric-up-alt"></i> Quantity</label>
                               <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ $product->quantity }}" min="1">
                               @error('capacity')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>
                           <div class="col-md-4">
                               <label for="category"><i class="fas fa-archive"></i> Category</label>
                               <select class="form-control @error('category') is-invalid @enderror" name="category">
                                   @foreach($category as $data)
                                     @if($data->id == $product->category_id)
                                      <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                     @else
                                      <option value="{{ $data->id }}">{{ $data->name }}</option>
                                     @endif
                                   @endforeach
                               </select>
                               @error('category')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>
                       </div>
                       <div class="form-group row">
                            <div class="col-md-2">
                                    <label for="price"><i class="fab fa-glide-g"></i> Code</label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ $product->code }}" maxlength="3">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="price"><i class="fas fa-dollar-sign"></i> Price</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ $product->price }}">
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                       </div>
                       <div class="form-group row">
                           <div class="col-md-8">
                               <label for="description">Description</label>
                               <textarea class="form-control" rows="20" cols="60" name="description">{{ $product->description }}</textarea>
                               @error('description')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div> 
                       </div>
                       <div class="form-group row">
                            <div class="col-md-8">
                                <label for="price"><span class="text-danger">*</span> <i class="fas fa-image"></i> Image</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                            </div>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                       </div>
                       <span class="text-danger">* Blank the image if you don't want update it</span><br>
                       @if(file_exists('/storage/product/'.$product->image) || $product->image == 'default.png' || $product->image == null)
                       <img src="{{ asset('image/default.png') }}">
                       @else
                       <img src="{{ asset('/storage/product/'.$product->image) }}">
                       @endif
                       <div class="form-group row">
                            <div class="col-md-8">
                                <input type="submit" name="store" class="btn btn-success">
                            </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
