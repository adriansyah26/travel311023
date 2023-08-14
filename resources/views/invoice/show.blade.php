<!DOCTYPE html>
<html lang="en">
@include('include.title')

<body class="fixed">
    <div class="card">
        <div class="card-body">
            <div class="container mb-5 mt-3">
                <div class="row d-flex align-items-baseline">
                    <div class="col-xl-12 float-start">
                        <img src="{{ public_path('image/travellogo3.png') }}" alt="image invoice" style="width:225px;height:150px;">
                        <div class="col-xl-7 float-end">
                            <a class="btn btn-light text-capitalize border-0" data-mdb-ripple-color="dark"><i class="fas fa-print text-primary"></i> Print</a>
                            <a class="btn btn-light text-capitalize" data-mdb-ripple-color="dark"><i class="far fa-file-pdf text-danger"></i> Export</a>
                            <div class="col-xl-5 float-end">
                                <h6>PT KAMAIRA SOLUSI PRATAMA Casa Verde Building 4rd Floor Jl Mampang Prapatan Nomor 17 K Jakarta Selatan, 12790 Indonesia</h6>
                            </div>
                        </div>
                        <hr>
                    </div>

                    <div class="container">
                        <div class="col-md-12">
                            <div class="text-center">
                                <!-- <i class="fab fa-mdb fa-4x ms-0" style="color:#5d9fc5 ;"></i> -->
                                <h3 class="col-xl-12">INVOICE</h3>
                                <h3 class="col-xl-12">{{ $invoice->invoice_number }}</h3>
                            </div>
                        </div>
                        <div style="border-top: 15px ridge#87CEEB; margin-top: 1em; padding-top: 1em;"> </div>

                        <div class="card mb-4 mt-3 px-4 col-md-6">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-8">
                                        <ul class="list-unstyled">
                                            <p class="text">Customers</p>
                                            <li class="text">Nama : {{ $invoice->customer?->name }}</li>
                                            <li class="text">Note :</li>
                                            <li class="text-muted"><i class="fas fa-phone"></i> 123-456-789</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-xl-4">
                            <p class="text-muted">Invoice</p>
                            <ul class="list-unstyled">
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span class="fw-bold">ID:</span>#123-456</li>
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span class="fw-bold">Creation Date: </span>Jun 23,2021</li>
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span class="me-1 fw-bold">Status:</span><span class="badge bg-warning text-black fw-bold">
                                        Unpaid</span></li>
                            </ul>
                        </div> -->
                        </div>

                        <div class="row my-2 mx-1 justify-content-center">
                            <table class="table table-striped table-bordered">
                                <thead style="background-color:#87CEEB ;" class="text-black">
                                    <tr>
                                        <th scope="col">NO</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Item</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $invoice->id }}</th>
                                        <td>{{ $invoice->product }}</td>
                                        <td>{{ $invoice->item }}</td>
                                        <td>{{ $invoice->quantity }}</td>
                                        <td>{{ $invoice->amount }}</td>
                                        <td>{{ $invoice->total }}</td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                        <div class="row">
                            <div class="col-xl-8">
                                <p class="ms-3">Terbilang : Dua juta enam ratus lima belas ribu rupiah</p>

                            </div>
                            <div class="col-xl-3">
                                <ul class="list-unstyled">
                                    <li class="text-muted ms-3"><span class="text-black me-4">SubTotal</span>$1110</li>
                                    <li class="text-muted ms-3 mt-2"><span class="text-black me-4">Tax(15%)</span>$111</li>
                                </ul>
                                <p class="text-black float-start"><span class="text-black me-3"> Total Amount</span><span style="font-size: 25px;">$1221</span></p>
                            </div>
                        </div>
                        <hr>
                        <div class="card mb-4 mt-3 px-4 col-md-6">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <ul class="list-unstyled">
                                            <p>Payment Detail</p>
                                            <li class="text">Silahkan melakukan pembayaran ke rekening bank berikut :</li>
                                            <li class="text">Bank BRI :</li>
                                            <li class="text">Nama Pemilik Rekening : PT KAMAIRA SOLUSI PRATAMA</li>
                                            <li class="text">Account No : 2020-01-000336-30-0</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <button type="button" class="btn btn-primary text-capitalize" style="background-color:#60bdf3 ;">Pay Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('include.script')
</body>

</html>