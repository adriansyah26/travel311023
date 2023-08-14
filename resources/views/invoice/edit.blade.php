@extends('layout.apps')
@section('content')
<main>
    <div class="container mt-3 px-4">
        <div class="col-lg-12 margin-tb">
            <div>
                <h2>Edit New Invoice</h2>
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

            <form action="{{ route('invoice.update',$invoice->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card mb-4 mt-3 px-4 col-lg-12">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-4 margin-tb px-4">
                                    <div class="form-group">
                                        <strong>Invoice Number:</strong>
                                        <input type="text" name="invoice_number" value="{{ $invoice->invoice_number }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4 margin-tb px-4">
                                    <div class="form-group">
                                        <strong>Customers_Name:</strong>
                                        <select class="form-control" name="customer_id">
                                            <option value="{{ $invoice->customer->id }}">{{ $invoice->customer->name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 margin-tb px-4">
                                    <div class="form-group">
                                        <strong>Status</strong>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 margin-tb mt-3 px-4">
                                    <button type="button" class="btn btn-success" onclick="saveItemsAndSubmit()">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 mt-3 px-4 col-lg-12 ">
                    <div class="card-body" style="overflow-x: auto;">
                        <div class="container-fluid">
                            <table id="itemTable" class="table table-bordered table-striped mt-3" style="margin-left: 10px; width: 950px; table-layout: fixed;">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;">No</th>
                                        <th style="width: 100px;">Products</th>
                                        <th style="width: 300px;">Item</th>
                                        <th style="width: 500px;">Description</th>
                                        <th style="width: 90px;">Quantity</th>
                                        <th style="width: 100px;">Amount</th>
                                        <th style="width: 100px;">Markup</th>
                                        <th style="width: 100px;">Total</th>
                                        <th style="width: 70px;">Action</th>
                                    </tr>
                                </thead>
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <tbody id="itemRows">
                                    <!-- <input type="hidden" name="items" id="itemData" /> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <div class="col-lg-12 margin-tb">
                        <div style="margin-left: 806px;">
                            <a class="btn btn-primary" href="{{ route('invoice.index') }}">Back</a>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var switchCheckbox = document.getElementById('mySwitchCheckbox');
        var switchInput = document.querySelector('input[name="status"]');

        switchCheckbox.addEventListener('change', function() {
            if (switchCheckbox.checked) {
                switchInput.value = 'True';
            } else {
                switchInput.value = 'False';
            }
        });
    });
</script>

<script>
    function edit() {
        var txtFirstNumberValue = document.getElementById('qty').value;
        var txtSecondNumberValue = document.getElementById('amt').value;
        var txtThirdNumberValue = document.getElementById('mkp').value;
        var result = parseInt(txtFirstNumberValue) * (parseInt(txtSecondNumberValue) + parseInt(txtThirdNumberValue));
        if (!isNaN(result)) {
            document.getElementById('ttl').value = result;
        }
    }
</script>
@endsection