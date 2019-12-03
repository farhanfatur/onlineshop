@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Edit Quantity</div>

                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                     {{$errors->first()}}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('updateQuantityCart') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <div class="form-group row">
                            <div class="col-md-5">
                                <label for="quantity">Quantity</label>
                                @foreach(Session::get('cart') as $data)
                                    @if($data['id'] == $id)
                                        <input type="number" name="capacity" value="{{ $data['capacity'] }}" class="form-control">
                                        @break
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <input type="submit" name="submit" value="Edit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
