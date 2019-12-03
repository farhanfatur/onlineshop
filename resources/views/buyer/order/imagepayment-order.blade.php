@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Image Payment</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('storeImagePayment') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <label for="imagepayment">Image Payment</label>
                                <input type="file" name="imagepayment" class="form-control">
                            </div>
                        </div>
                        @if($order->imagepayment != null)
                        <p>Your payment receive before :</p>
                        <img src="{{ asset('storage/buyer/'.$order->imagepayment) }}">
                        @endif
                        <div class="form-group row">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
