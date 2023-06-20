@extends('pengguna.layout')
  
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div>
                <h2> Show Pengguna</h2>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('pengguna.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nama:</strong>
                {{ $pengguna->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {{ $pengguna->email }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Phone:</strong>
                {{ $pengguna->phone }}
            </div>
        </div>
    </div>
@endsection