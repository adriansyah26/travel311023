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
            <main>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="float-start">
                            <h2>Type</h2>
                        </div>
                        <div class="container mt-3 px-4">
                            <div class="col-lg-12 margin-tb">
                                <div class="float-end">
                                    <a class="btn btn-success" href="{{ route('type.create') }}"> Create New Type</a>
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
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th width="200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($type as $tpe)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $tpe->code }}</td>
                                            <td>{{ $tpe->name }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <!-- <a class="btn btn-info me-1" href="{{ route('type.show',$tpe->id) }}">Show</a> -->
                                                    <a class="btn btn-primary me-1" href="{{ route('type.edit',$tpe->id) }}">Edit</a>
                                                    <form action="{{ route('type.destroy',$tpe->id) }}" method="POST">
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