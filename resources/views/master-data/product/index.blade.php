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
                            <div class="collapse show" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
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
                        <h2>Products</h2>
                    </div>
                    <div class="container mt-3 px-4">
                        <div class="col-lg-12 margin-tb">
                            <div class="float-end">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalCreate">
                                    Create New Products
                                </button>
                            </div>
                        </div>
                    </div>
@include('master-data.product.create')
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
                    <th>Code</th>
                    <th>Name</th>
                    <th width="200px">Action</th>
                </tr>
                @foreach ($product as $pdt)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $pdt->code }}</td>
                    <td>{{ $pdt->name }}</td>                                                                         
                    <td>
                        <div class="d-flex">
                            <!-- <a class="btn btn-info me-1" href="{{ route('product.show',$pdt->id) }}">Show</a> -->
                            <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#exampleModalEdit-{{ $pdt->id }}">
                                Edit
                            </button>
@include('master-data.product.edit')
                            <form action="{{ route('product.destroy',$pdt->id) }}" method="POST">
                                @csrf                           
                                @method('DELETE') 
                                <button type="submit" class="btn btn-danger me-1">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="row text-center container mt-3 px-4">
                <nav aria label ="page navigation example">
                    <ul class="pagination justify-content-center">
                        <li>{!! $product->links() !!}</li>
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