@extends('layout.app')
@section('content')
<main>
    <div class="container mt-3 px-4">
        <div class="col-lg-12 margin-tb">
            <div>
                <h2>Edit New Products</h2>
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
                    <form action="{{ route('product.update',$product->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="container px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="form-group">
                                    <strong>Code:</strong>
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="code">
                                            <option value="F001">F001</option>
                                            <option value="T001">T001</option>
                                            <option value="H001">H001</option>
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
                                        <select class="form-select" name="name">
                                            <option value="Flight">Flight</option>
                                            <option value="Train">Train</option>
                                            <option value="Hotel">Hotel</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3">
                            <div class="col-lg-12 margin-tb">
                                <div style="margin-left: 290px;">
                                    <a class="btn btn-primary" href="{{ route('product.index') }}"> Back</a>
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