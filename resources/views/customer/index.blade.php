@extends('layout.apps')
@section('content')
<main>
    <div class="container mt-3 px-4">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Customers</h2>
            </div>
            <div class="container mt-3 px-4">
                <div class="col-lg-12 margin-tb">
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('customer.create') }}"><i class="bi bi-file-earmark-plus"></i> New Customers</a>
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
                                <th style="width: 150px;">Name</th>
                                <th style="width: 100px;">Phone</th>
                                <th style="width: 200px;">Email</th>
                                <th style="width: 250px;">Address</th>
                                <th style="width: 80px;">Type</th>
                                <th style="width: 70px;">Action</th>
                            </tr>
                        </thead>
                        </tbody>
                        @foreach ($customer as $i => $cst)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $cst->name }}</td>
                            <td>{{ $cst->phone }}</td>
                            <td>{{ $cst->email }}</td>
                            <td>{{ $cst->address }}</td>
                            <td>{{ $cst->type }}</td>
                            <td>
                                <div class="d-flex">
                                    <a class="btn btn-primary me-1" href="{{ route('customer.edit',$cst->id) }}"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('customer.destroy',$cst->id) }}" method="POST">
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