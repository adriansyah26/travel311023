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

            <form action="{{ route('customer.update',$customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card mb-4 mt-3 px-4 col-lg-12">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6 margin-tb">
                                    <div class="form-group">
                                        <strong>Name</strong>
                                        <input type="text" name="name" value="{{ $customer->name }}" class="form-control" placeholder="Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 margin-tb">
                                    <div class="form-group">
                                        <strong>Phone</strong>
                                        <input class="form-control" name="phone" placeholder="Phone" type="number" value="{{ $customer->phone }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6 margin-tb">
                                    <div class="form-group">
                                        <strong>Email</strong>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" value="{{ $customer->email }}" required>
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 margin-tb">
                                    <div class="form-group">
                                        <strong>Termin</strong>
                                        <input type="text" name="termin" class="form-control" placeholder="Termin" value="{{ $customer->termin }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6 margin-tb">
                                    <div class="form-group">
                                        <strong>Type</strong>
                                        <div class="input-group mb-3">
                                            <select class="form-select" name="type_id">
                                                @foreach ($types as $type)
                                                <option value="{{ $type->id }}" {{ $type->id == $customer->type_id ? 'selected' : '' }}>{{ $type->name }}</option>
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 margin-tb">
                                    <div class="form-group">
                                        <strong>Address</strong>
                                        <textarea class="form-control" name="address" placeholder="Address" required>{{ $customer->address }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12 margin-tb">
                                <div style="margin-left: 843px;">
                                    <a class="btn btn-primary" href="{{ route('customer.index') }}"> Back</a>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection