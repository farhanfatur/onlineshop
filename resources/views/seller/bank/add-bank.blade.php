@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fas fa-university"></i> Add Bank</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('storeBank') }}">
                      @csrf
                       <div class="form-group row">
                           <div class="col-md-8">
                               <label for="name"><i class="fas fa-university"></i> Name</label>
                               <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                               @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>
                       </div>
                       <div class="form-group row">
                           <div class="col-md-8">
                               <label for="capacity"><i class="fab fa-cc-mastercard"></i> Rekening</label>
                               <input type="number" name="rekening" class="form-control" value="{{ old('rekening') }}">
                               @error('rekening')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>
                       </div>
                       <div class="form-group row">
                           <div class="col-md-8">
                               <label for="description"><i class="fas fa-user"></i> Holder</label>
                               <input type="text" name="holder" class="form-control" value="{{ old('holder') }}">
                               @error('holder')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div> 
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
