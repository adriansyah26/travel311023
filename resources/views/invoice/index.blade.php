@extends('layout.apps')
@section('content')
<main>
    <div class="container mt-3 px-4">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Invoice</h2>
            </div>
            <div class="container mt-3 px-4">
                <div class="col-lg-12 margin-tb">
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('invoice.create') }}"> Create New Invoice</a>
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
                                <th>Invoice Number</th>
                                <th>Products</th>
                                <th>Item</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Markup</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th width="200px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice as $ive)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $ive->invoice_number }}</td>
                                <td>{{ $ive->product }}</td>
                                <td>{{ $ive->item }}</td>
                                <td>{{ $ive->description }}</td>
                                <td>{{ $ive->quantity }}</td>
                                <td>{{ $ive->amount }}</td>
                                <td>{{ $ive->markup }}</td>
                                <td>{{ $ive->total }}</td>
                                <td>{{ $ive->status }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-primary me-1" href="{{ route('invoice.edit',$ive->id) }}">Edit</a>
                                        <form action="{{ route('invoice.destroy',$ive->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger me-1">Delete</button>
                                        </form>
                                        <a class="btn btn-info me-1" target="blank" href="{{ route('invoice.show',$ive->id) }}">Generate</a>
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