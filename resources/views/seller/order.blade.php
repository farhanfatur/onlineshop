@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Staff</div>

                <div class="card-body">
                   
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Date Birth</th>
                            <th>Action</th>
                        </tr>
                                               
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
