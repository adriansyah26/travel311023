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
                        <a class="btn btn-success" href="{{ route('customer.create') }}"> Create New customers</a>
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
                                <th>No</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Type</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                        </tbody>
                        @foreach ($customer as $cst)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $cst->name }}</td>
                            <td>{{ $cst->phone }}</td>
                            <td>{{ $cst->email }}</td>
                            <td>{{ $cst->address }}</td>
                            <td>{{ $cst->type }}</td>
                            <td>
                                <div class="d-flex">
                                    <!-- <a class="btn btn-info me-1" href="{{ route('customer.show',$cst->id) }}">Show</a>                           -->
                                    <a class="btn btn-primary me-1" href="{{ route('customer.edit',$cst->id) }}">Edit</a>
                                    <form action="{{ route('customer.destroy',$cst->id) }}" method="POST">
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