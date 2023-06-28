<!-- Modal --> 

<div class="modal fade" id="exampleModalEdit-{{ $ive->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Invoice</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
<!-- content edit -->
      <div class="modal-body">
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
            <form action="{{ route('invoice.update', $ive->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Invoice Number:</strong>
                            <input type="text" name="invoice_number" value="{{ $ive->invoice_number }}" class="form-control" placeholder="Invoice Number">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Products:</strong>
                                <div class="input-group mb-3">
                                    <select class="form-select" name="product">
                                        <option value="Flight">Flight</option>
                                        <option value="Train">Train</option>
                                        <option value="Hotel">Hotel</option>
                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Item:</strong>
                            <input type="text" name="item" value="{{ $ive->item }}" class="form-control" placeholder="Item">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Description:</strong>
                            <input type="text" name="description" value="{{ $ive->description }}" class="form-control" placeholder="Description">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Quantity:</strong>
                            <input class="form-control" name="quantity" placeholder="Quantity" value="{{ $ive->quantity }}">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Amount:</strong>
                            <input class="form-control" name="amount" placeholder="Amount" value="{{ $ive->amount }}">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Markup:</strong>
                            <input class="form-control" name="markup" placeholder="Markup" value="{{ $ive->markup }}">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Total:</strong>
                            <input class="form-control" name="total" placeholder="Total" value="{{ $ive->total }}">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Status:</strong>
                            <input class="form-control" name="status" placeholder="Status" value="{{ $ive->status }}">
                        </div>
                    </div>
                </div>
                </div>
                <div class="container mt-1 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
    </div>
  </div>
</div>

<!-- endcontent edit -->