<!DOCTYPE html>
<html lang="en">
@include('include.title')

<body class="sb-nav-fixed">
    @include('include.navbar')
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">HALAMAN UTAMA</div>
                        <a class="nav-link" href="/dashboard">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">ANTARMUKA</div>
                        <a class="nav-link" href="/invoice">
                            <div class="sb-nav-link-icon"><i class="bi bi-receipt"></i></div>
                            Invoice
                        </a>
                        <a class="nav-link" href="/pengguna">
                            <div class="sb-nav-link-icon"><i class="bi bi-person"></i></div>
                            Users
                        </a>
                        <a class="nav-link" href="/customer">
                            <div class="sb-nav-link-icon"><i class="bi bi-people"></i></div>
                            Customers
                        </a>
                        <a class="nav-link collapsed" href="master-data" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="bi bi-bar-chart-fill"></i></div>
                            Master Data
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="/product">Products</a>
                                <a class="nav-link" href="/type">Type</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div>
            </nav>
        </div>

        <!-- content -->
        <div id="layoutSidenav_content">
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
                        <div class="card mb-4 mt-3 px-4 col-lg-12">
                            <div class="card-body">
                                <form action="{{ route('invoice.update',$invoice->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-6 margin-tb px-4">
                                                <div class="form-group">
                                                    <strong>Invoice Number:</strong>
                                                    <input type="text" name="invoice_number" value="{{ $invoice->invoice_number }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 margin-tb px-4">
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
                                        <div class="row">
                                            <div class="col-lg-6 margin-tb px-4">
                                                <div class="form-group">
                                                    <strong>Item:</strong>
                                                    <input type="text" name="item" value="{{ $invoice->item }}" class="form-control" placeholder="Item">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 margin-tb px-4">
                                                <div class="form-group">
                                                    <strong>Quantity:</strong>
                                                    <input class="form-control" name="quantity" placeholder="Quantity" type="number" value="{{ $invoice->quantity }}" onkeyup="edit();" id="qty">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 margin-tb mt-3 px-4">
                                                <div class="form-group">
                                                    <strong>Amount:</strong>
                                                    <input class="form-control" name="amount" placeholder="Amount" type="number" value="{{ $invoice->amount }}" onkeyup="edit();" id="amt">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 margin-tb mt-3 px-4">
                                                <div class="form-group">
                                                    <strong>Markup:</strong>
                                                    <input class="form-control" name="markup" placeholder="Markup" type="number" value="{{ $invoice->markup }}" onkeyup="edit();" id="mkp">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 margin-tb mt-3 px-4">
                                                <div class="form-group">
                                                    <strong>Total:</strong>
                                                    <input class="form-control" name="total" type="number" value="{{ $invoice->total }}" readonly onkeyup="edit();" id="ttl">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 margin-tb mt-3 px-4">
                                                <div class="form-group">
                                                    <strong>Status:</strong>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="status" value="True" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 margin-tb mt-3 px-4">
                                                <div class="form-group">
                                                    <strong>Description:</strong>
                                                    <textarea type="text" name="description" class="form-control" required>{{$invoice->description}}</textarea>
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
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    @include('include.script')
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
</body>

</html>


<!-- endcontent edit -->