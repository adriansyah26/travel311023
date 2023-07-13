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
                            <h2>Edit New Users</h2>
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
                        <div class="card mb-4 mt-3 px-4 col-lg-6 ">
                            <div class="card-body">
                                <form action="{{ route('pengguna.update',$pengguna->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="container px-4">
                                        <div class="col-lg-12 margin-tb">
                                            <div class="form-group">
                                                <strong>Title:</strong>
                                                <div class="input-group mb-3">
                                                    <select class="form-select" name="title">
                                                        <option value="Mr">Mr</option>
                                                        <option value="Mrs">Mrs</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container mt-3 px-4">
                                        <div class="col-lg-12 margin-tb">
                                            <div class="form-group">
                                                <strong>First Name:</strong>
                                                <input type="text" name="first_name" value="{{ $pengguna->first_name }}" class="form-control" placeholder="First Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container mt-3 px-4">
                                        <div class="col-lg-12 margin-tb">
                                            <div class="form-group">
                                                <strong>Last Name:</strong>
                                                <input type="text" name="last_name" value="{{ $pengguna->last_name }}" class="form-control" placeholder="Last Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container mt-3 px-4">
                                        <div class="col-lg-12 margin-tb">
                                            <div class="form-group">
                                                <strong>Phone:</strong>
                                                <input class="form-control" name="phone" placeholder="Phone" type="number" value="{{ $pengguna->phone }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container mt-3 px-4">
                                        <div class="col-lg-12 margin-tb">
                                            <div class="form-group">
                                                <strong>Email:</strong>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" value="{{ $pengguna->email }}">
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container mt-3">
                                        <div class="col-lg-12 margin-tb">
                                            <div style="margin-left: 280px;">
                                                <a class="btn btn-primary" href="{{ route('pengguna.index') }}"> Back</a>
                                                <button type="submit" class="btn btn-success">Submit</button>
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
</body>

</html>

<!-- endcontent edit -->