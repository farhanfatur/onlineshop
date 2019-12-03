@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Product</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('storeProduct') }}" enctype="multipart/form-data">
                      @csrf
                       <div class="form-group row">
                           <div class="col-md-8">
                               <label for="name">Name</label>
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
                               <label for="capacity">Quantity</label>
                               <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('capacity') }}">
                               @error('capacity')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>
                           <div class="col-md-4">
                               <label for="category">Category</label>
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
                                    <label for="price">Code</label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" maxlength="3">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="price">Price</label>
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
                               <label for="description">Description</label>
                               <textarea class="form-control @error('description') is-invalid @enderror" rows="20" cols="60" name="description">{{ old('description') }}</textarea>
                               @error('description')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div> 
                       </div>
                       <div class="form-group row">
                            <div class="col-md-8">
                                <label for="price">Image</label>
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
@endsection
