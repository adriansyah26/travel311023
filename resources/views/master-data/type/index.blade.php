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
                        <a class="btn btn-success" href="{{ route('type.create') }}"><i class="bi bi-file-earmark-plus"></i> New Type</a>
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
                <div class="card-body" style="overflow-x: auto;">
                    <table id="table" class="table  table-striped table-bordered" style="table-layout: fixed;">
                        <thead>
                            <tr>
                                <th style="width: 30px;">No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th style="width: 70px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($type as $i => $tpe)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $tpe->code }}</td>
                                <td>{{ $tpe->name }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-primary me-1" href="{{ route('type.edit',$tpe->id) }}"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('type.destroy',$tpe->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger me-1"><i class="bi bi-trash"></i></button>
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