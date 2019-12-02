@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Category</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('storeCategory') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input type="submit" name="submit" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
