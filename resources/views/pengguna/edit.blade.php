@extends('layout.apps')
@section('content')
<main>
    <div class="container mt-3 px-4">
        <div class="col-lg-12 margin-tb">
            <div>
                <h2>Edit New Users</h2>
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
                    <form action="{{ route('pengguna.update',$pengguna->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="container px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="form-group">
                                    <strong>Title</strong>
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="title">
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3 px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="form-group">
                                    <strong>First Name</strong>
                                    <input type="text" name="first_name" value="{{ $pengguna->first_name }}" class="form-control" placeholder="First Name">
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3 px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="form-group">
                                    <strong>Last Name</strong>
                                    <input type="text" name="last_name" value="{{ $pengguna->last_name }}" class="form-control" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3 px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="form-group">
                                    <strong>Phone</strong>
                                    <input class="form-control" name="phone" placeholder="Phone" type="number" value="{{ $pengguna->phone }}">
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3 px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="form-group">
                                    <strong>Email</strong>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" value="{{ $pengguna->email }}">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3">
                            <div class="col-lg-12 margin-tb">
                                <div style="margin-left: 280px;">
                                    <a class="btn btn-primary" href="{{ route('pengguna.index') }}"> Back</a>
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