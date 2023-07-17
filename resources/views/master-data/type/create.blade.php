@extends('layout.app')
@section('content')
<main>
    <div class="container mt-3 px-4">
        <div class="col-lg-12 margin-tb">
            <div>
                <h2>Add New Type</h2>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card mb-4 mt-3 px-4 col-lg-6 ">
                <div class="card-body">
                    <form action="{{ route('type.store') }}" method="POST">
                        @csrf

                        <div class="container px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="form-group">
                                    <strong>Code:</strong>
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="code" value="{{ old('code') }}">
                                            <option value="P001">P001</option>
                                            <option value="C001">C001</option>
                                            <option value="G001">G001</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3 px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="name" value="{{ old('name') }}">
                                            <option value="Personal">Personal</option>
                                            <option value="Corporate">Corporate</option>
                                            <option value="Goverment">Goverment</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3">
                            <div class="col-lg-12 margin-tb">
                                <div style="margin-left: 290px;">
                                    <a class="btn btn-primary" href="{{ route('type.index') }}"> Back</a>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection