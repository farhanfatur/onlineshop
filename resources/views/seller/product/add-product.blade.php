@extends('layouts.app')

@push('css')
<link rel="stylesheet" type="text/css" href="#">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fas fa-box"></i> Add Product</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('storeProduct') }}" enctype="multipart/form-data">
                      @csrf
                       <div class="form-group row">
                           <div class="col-md-8">
                               <label for="name"><i class="fas fa-user-alt"></i> Name</label>
                               <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
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
                               <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('capacity') }}" min="1">
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
                                   <option value="{{ $data->id }}">{{ $data->name }}</option>
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
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" maxlength="3">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="price"><i class="fas fa-dollar-sign"></i> Price</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                       </div>
                       <div class="form-group row">
                           <div class="col-md-8">
                               <label for="description"><i class="fas fa-keyboard"></i> Description</label>
                               <textarea class="form-control @error('description') is-invalid @enderror" rows="20" cols="60" name="description" id="description">{{ old('description') }}</textarea>
                               @error('description')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                           </div> 
                       </div>
                       <div class="form-group row">
                            <div class="col-md-8">
                                <label for="price"><i class="fas fa-image"></i> Image</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                            </div>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                       </div>
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

@push('javascript')
<script type="text/javascript" src="#"></script>
@endpush