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
                        <a class="btn btn-success" href="{{ route('invoice.create') }}"><i class="bi bi-file-earmark-plus"></i> New Invoice</a>
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
                                <th style="width: 150px;">Invoice Number</th>
                                <th>Customers Name</th>
                                <!-- <th style="width: 70px;">Products</th>
                                <th style="width: 300px;">Item</th>
                                <th style="width: 300px;">Description</th>
                                <th style="width: 70px;">Quantity</th>
                                <th style="width: 70px;">Amount</th>
                                <th style="width: 70px;">Markup</th>
                                <th style="width: 70px;">Total</th> -->
                                <th style="width: 50px;">Status</th>
                                <th style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice as $i => $ive)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $ive->invoice_number }}</td>
                                <td>{{ $ive->customer->name }}</td>
                                <!-- <td>{{ $ive->product }}</td>
                                <td>{{ $ive->item }}</td>
                                <td>{{ $ive->description }}</td>
                                <td>{{ $ive->quantity }}</td>
                                <td>{{ $ive->amount }}</td>
                                <td>{{ $ive->markup }}</td>
                                <td>{{ $ive->total }}</td> -->
                                <td>{{ $ive->status }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-primary me-1" href="{{ route('invoice.edit',$ive->id) }}"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('invoice.destroy',$ive->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger me-1"><i class="bi bi-trash"></i></button>
                                        </form>
                                        <a class="btn btn-info me-1" target="blank" href="{{ route('invoice.show',$ive->id) }}"><i class="bi bi-filetype-pdf text-white"></i></a>
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