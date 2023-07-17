@extends('layout.app')
@section('content')
<main>
    <div class="container mt-3 px-4">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Type</h2>
            </div>
            <div class="container mt-3 px-4">
                <div class="col-lg-12 margin-tb">
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('type.create') }}"> Create New Type</a>
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
                                <th>Code</th>
                                <th>Name</th>
                                <th width="200px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($type as $tpe)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $tpe->code }}</td>
                                <td>{{ $tpe->name }}</td>
                                <td>
                                    <div class="d-flex">
                                        <!-- <a class="btn btn-info me-1" href="{{ route('type.show',$tpe->id) }}">Show</a> -->
                                        <a class="btn btn-primary me-1" href="{{ route('type.edit',$tpe->id) }}">Edit</a>
                                        <form action="{{ route('type.destroy',$tpe->id) }}" method="POST">
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