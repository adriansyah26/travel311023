@extends('layout.apps')
@section('content')
<main>
    <div class="container mt-3 px-4">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Users</h2>
            </div>
            <div class="container mt-3 px-4">
                <div class="col-lg-12 margin-tb">
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('pengguna.create') }}"> Create New Users</a>
                    </div>
                </div>
            </div>

            <div class="row container mt-1 px-4">
                @if ($message = Session::get('success'))
                <div class="alert alert-success container mt-1 px-4">
                    <p>{{ $message }}</p>
                </div>
                @endif
            </div>
            <div class="card mb-4 mt-3 px-4">
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th width="50px">No</th>
                                <th>Title</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengguna as $pna)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $pna->title }}</td>
                                <td>{{ $pna->first_name }}</td>
                                <td>{{ $pna->last_name }}</td>
                                <td>{{ $pna->phone }}</td>
                                <td>{{ $pna->email }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-info me-1" href="{{ route('pengguna.show',$pna->id) }}">Show</a>
                                        <a class="btn btn-primary me-1" href="{{ route('pengguna.edit',$pna->id) }}">Edit</a>
                                        <form action="{{ route('pengguna.destroy',$pna->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger me-1">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection