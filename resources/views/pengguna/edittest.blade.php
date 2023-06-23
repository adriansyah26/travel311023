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
                            <a class="nav-link" href="dashboard.index">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">ANTARMUKA</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Layouts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="pengguna">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Users
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
<!-- content -->
            <div class="container mt-3 px-4">
                <div class="col-lg-12 margin-tb">
                    <div>
                        <h2>Edit Users</h2>
                    </div>
                    <div>
                        <a class="btn btn-primary" href="{{ route('pengguna.index') }}"> Back</a>
                    </div>
                </div>
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
  
            <form action="{{ route('pengguna.update',$pengguna->id) }}" method="POST">
                @csrf
                @method('PUT')
        
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Nama:</strong>
                            <input type="text" name="name" value="{{ $pengguna->name }}" class="form-control" placeholder="Nama">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Email:</strong>
                            <input class="form-control" name="email" placeholder="Email" value="{{ $pengguna->email }}">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Phone:</strong>
                            <input class="form-control" name="phone" placeholder="Phone" value="{{ $pengguna->phone }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>   
            </form>
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