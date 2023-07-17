@extends('layout.apps')
@section('content')
<main>
    <div class="container mt-3 px-4">
        <div class="col-lg-12 margin-tb">
            <div>
                <h2>Add New Invoice</h2>
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
            <div class="card mb-4 mt-3 px-4 col-lg-12 ">
                <div class="card-body">
                    <form action="{{ route('invoice.store') }}" method="POST">
                        @csrf

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6 margin-tb px-4">
                                    <div class="form-group">
                                        <strong>Invoice Number:</strong>
                                        <input type="text" name="invoice_number" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6 margin-tb px-4">
                                    <div class="form-group">
                                        <strong>Products:</strong>
                                        <div class="input-group mb-3">
                                            <select class="form-select" name="product">
                                                @foreach ($products as $product)
                                                <option value="{{ $product->name }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 margin-tb px-4">
                                    <div class="form-group">
                                        <strong>Item:</strong>
                                        <input type="text" name="item" class="form-control" placeholder="Item" value="{{ old('item') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 margin-tb px-4">
                                    <div class="form-group">
                                        <div class="form-outline">
                                            <strong>Quantity:</strong>
                                            <input class="form-control" name="quantity" placeholder="Quantity" type="number" value="{{ old('quantity') }}" onkeyup="create();" id="quantity"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 margin-tb mt-3 px-4">
                                    <div class="form-group">
                                        <strong>Amount:</strong>
                                        <input class="form-control" name="amount" placeholder="Amount" type="number" value="{{ old('amount') }}" onkeyup="create();" id="amount"></input>
                                    </div>
                                </div>
                                <div class="col-lg-6 margin-tb mt-3 px-4">
                                    <div class="form-group">
                                        <strong>Markup:</strong>
                                        <input class="form-control" name="markup" placeholder="Markup" type="number" value="{{ old('markup') }}" onkeyup="create();" id="markup"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 margin-tb mt-3 px-4">
                                    <div class="form-group">
                                        <strong>Total:</strong>
                                        <input class="form-control" name="total" placeholder="Total" type="number" value="{{ old('total') }}" readonly onkeyup="create();" id="total"></input>
                                    </div>
                                </div>
                                <div class="col-lg-6 margin-tb mt-3 px-4">
                                    <div class="form-group">
                                        <strong>Status:</strong>
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="status" value="False">
                                            <input class="form-check-input" type="checkbox" id="mySwitchCheckbox" value="True">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 margin-tb mt-3 px-4">
                                    <div class="form-group">
                                        <strong>Description:</strong>
                                        <textarea type="text" name="description" class="form-control" placeholder="Description" required>{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="container mt-3">
                                <div class="col-lg-12 margin-tb">
                                    <div style="margin-left: 806px;">
                                        <a class="btn btn-primary" href="{{ route('invoice.index') }}"> Back</a>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
    function create() {
        var txtFirstNumberValue = document.getElementById('quantity').value;
        var txtSecondNumberValue = document.getElementById('amount').value;
        var txtThirdNumberValue = document.getElementById('markup').value;
        var result = parseInt(txtFirstNumberValue) * (parseInt(txtSecondNumberValue) + parseInt(txtThirdNumberValue));
        if (!isNaN(result)) {
            document.getElementById('total').value = result;
        }
    }
</script>
@endsection