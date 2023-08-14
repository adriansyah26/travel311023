@extends('layout.apps')
@section('content')
<main>
    <div class="container mt-3 px-4">
        <div class="col-lg-12 margin-tb">
            <div>
                <h2>Edit New Customers</h2>
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
                    <form action="{{ route('customer.update',$customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="container px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="form-group">
                                    <strong>Name</strong>
                                    <input type="text" name="name" value="{{ $customer->name }}" class="form-control" placeholder="Name">
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3 px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="form-group">
                                    <strong>Phone</strong>
                                    <input class="form-control" name="phone" placeholder="Phone" type="number" value="{{ $customer->phone }}">
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3 px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="form-group">
                                    <strong>Email</strong>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" value="{{ $customer->email }}">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3 px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="form-group">
                                    <strong>Address</strong>
                                    <input type="text" name="address" value="{{ $customer->address }}" class="form-control" placeholder="Address">
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3 px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="form-group">
                                    <strong>Type</strong>
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="type">
                                            @foreach ($types as $type)
                                            <option value="{{ $type->name }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3">
                            <div class="col-lg-12 margin-tb">
                                <div style="margin-left: 280px;">
                                    <a class="btn btn-primary" href="{{ route('customer.index') }}"> Back</a>
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