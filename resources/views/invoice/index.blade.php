<!DOCTYPE html>
<html lang="en">
@include('include.title')
<body>
@include('include.navbar')
<div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">HALAMAN UTAMA</div>
                            <a class="nav-link" href="dashboard">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">ANTARMUKA</div>
                            <a class="nav-link" href="invoice">
                                <div class="sb-nav-link-icon"><i class="bi bi-receipt"></i></div>
                                Invoice
                            </a>
                            <a class="nav-link" href="pengguna">
                                <div class="sb-nav-link-icon"><i class="bi bi-person"></i></div>
                                Users
                            </a>
                            <a class="nav-link" href="customer">
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
                                    <a class="nav-link" href="product">Products</a>
                                    <a class="nav-link" href="type">Type</a>
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
            <div class="container mt-3 px-4">
                <div class="col-lg-12 margin-tb">
                    <div class="float-start">
                        <h2>Invoice</h2>
                    </div>
                    <div class="container mt-3 px-4">
                        <div class="col-lg-12 margin-tb">
                            <div class="float-end">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalCreate">
                                    Create New Invoice
                                </button>
                            </div>
                        </div>
                    </div>
@include('invoice.create')
            <div class="row container mt-1 px-4">
            @if ($message = Session::get('success'))
            <div class="alert alert-success container mt-1 px-4">
                <p>{{ $message }}</p>
            </div>
            @endif 
            </div>
            <table class="table table-bordered container mt-3 px-4" style="width: 1100px;">
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
                            
                            <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#exampleModalEdit-{{ $ive->id }}">
                                Edit
                            </button>
@include('invoice.edit')
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
            </table>
            <div class="row text-center container mt-3 px-4">
                <nav aria label ="page navigation example">
                    <ul class="pagination justify-content-center">
                        <li>{!! $invoice->links() !!}</li>
                    </ul>
                </nav>
            </div>
<!-- endcontent -->
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
</body>
</html>