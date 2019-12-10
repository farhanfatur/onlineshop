@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fas fa-university"></i> Bank</div>

                <div class="card-body">
                    <button class="btn btn-primary" onclick="window.location.href='/seller/bank/add'"><i class="fas fa-university"></i> Add Bank</button>
                   
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Rekening</th>
                            <th>Holder</th>
                            <th>Action</th>
                        </tr>
                        @php
                        $i = 1
                        @endphp
                        @foreach($bank as $data)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->rekening }}</td>
                            <td>{{ $data->holder }}</td>
                            <td><a href="/seller/bank/edit/{{ $data->id }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> | <a href="/seller/bank/delete/{{ $data->id }}" onclick="return confirm('Are you sure to delete this?')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
