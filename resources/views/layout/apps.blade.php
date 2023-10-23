<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" href="/image/titledanmenu.png">
    <title>K - Tour & Travel</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" /> -->
    <link href="/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- datatable -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- chart -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <!-- jquery -->
    <script src="{{ url('js/jquery-3.7.0.min.js') }}"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <!-- <a class="navbar-brand ps-3" href="/home">K - Tour & Travel</a> -->
        <a class="navbar-brand ps-3" href="/dashboard"><img style="width: 40px;" src="/image/titledanmenu.png"> K - Tour & Travel</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <!-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form> -->
        <a class="d-none d-md-inline-block form-inline ms-auto navbar-brand ps-3" href="/dashboard">Welcome {{ auth()->user()->first_name }}</a>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle custom-navbar-link" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <!-- <li><a class="dropdown-item" href="#!">Settings</a></li> -->
                    <li><button type="button" data-bs-toggle="modal" data-bs-target="#changepassword" data-userid="{{ auth()->user()->id }}" class="dropdown-item"><i class="fa-solid fa-gear"></i> Change Password</button></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    <!-- <li><a class="dropdown-item" href="#!">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <input type="submit" class="btn btn-danger" value="Logout">
                            </form>
                        </a>
                    </li> -->
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">MAIN PAGE</div>
                        <a class="nav-link" href="/dashboard">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">INTERFACE</div>
                        <a class="nav-link" href="/invoice">
                            <div class="sb-nav-link-icon"><i class="bi bi-receipt"></i></div>
                            Invoice
                        </a>
                        <a class="nav-link" href="/user">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                            Users
                        </a>
                        <a class="nav-link" href="/customer">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user-group" style="font-size: 12px;"></i></div>
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
                <!-- <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div> -->
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <!-- <content> -->
            <!-- The Modal ChangePassword-->
            <div class="modal fade" id="changepassword">
                <div class="modal-dialog  modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Change Password</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="card px-4 col-lg-12 ">
                                <div class="card-body">
                                    <form id="change_password_form">
                                        @csrf
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-12 margin-tb px-4">
                                                    <div class="form-group">
                                                        <input type="hidden" name="user_id" value="">
                                                        <strong>Old Password</strong>
                                                        <div class="input-group mb-3">
                                                            <input type="password" name="old_password" class="form-control" placeholder="Min 8 Characters" value="{{ old('old_password') }}" id="old_password" required autocomplete="off">
                                                            <span class="input-group-text toggle-password" data-target-change-password="old_password">
                                                                <i class="bi bi-eye" style="cursor: pointer;"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 margin-tb px-4">
                                                    <div class="form-group">
                                                        <strong>New Password</strong>
                                                        <div class="input-group mb-3">
                                                            <input type="password" name="new_password" class="form-control" placeholder="Min 8 Characters" value="{{ old('new_password') }}" id="new_password" required autocomplete="off">
                                                            <span class="input-group-text toggle-password" data-target-change-password="new_password">
                                                                <i class="bi bi-eye" style="cursor: pointer;"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 margin-tb px-4">
                                                    <div class="form-group">
                                                        <strong>Confirm New Password</strong>
                                                        <div class="input-group mb-3">
                                                            <input type="password" name="confirm_new_password" class="form-control" placeholder="Same New Password" value="{{ old('confirm_new_password') }}" id="confirm_new_password" required autocomplete="off">
                                                            <span class="input-group-text toggle-password" data-target-change-password="confirm_new_password">
                                                                <i class="bi bi-eye" style="cursor: pointer;"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="saveChangePassword()">Save</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
            <!-- </endcontent> -->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; PT KAMAIRA SOLUSI PRATAMA 2023, Casa Verde Building 4rd Floor, Jl Mampang Prapatan Nomor 17 K Jakarta Selatan, 12790 Indonesia</div>
                        <!-- <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div> -->
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- <jquery> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script> -->
    <!-- javascript -->
    <!-- <script src="/js/datatables-simple-demo.js"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/js/scripts.js"></script>
    @stack('scripts')

    <!-- datatable -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable(); // Ganti "#table" dengan ID atau selektor yang sesuai untuk tabel Anda.
        });
    </script>

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Change Password -->
    <script>
        const passwordInputs = document.querySelectorAll('.toggle-password');

        passwordInputs.forEach(function(input) {
            const targetId = input.getAttribute('data-target-change-password');
            const passwordInput = document.getElementById(targetId);

            input.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    input.innerHTML = '<i class="bi bi-eye-slash" style="cursor: pointer;"></i>';
                } else {
                    passwordInput.type = 'password';
                    input.innerHTML = '<i class="bi bi-eye" style="cursor: pointer;"></i>';
                }
            });

            // Inisialisasi input password sebagai tipe password
            passwordInput.type = 'password';
        });
    </script>

    <script>
        $('#changepassword').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var userId = button.data('userid'); // Ambil ID pengguna dari atribut data
            var modal = $(this);

            // Set nilai input tersembunyi dengan ID pengguna
            modal.find('input[name="user_id"]').val(userId);
        });

        // Tambahkan skrip Axios untuk mengirimkan permintaan perubahan password
        function saveChangePassword() {
            var form = $('#change_password_form');
            var formData = new FormData(form[0]); // Dapatkan data formulir

            axios.post('{{ route("user.updatechangePassword") }}', formData)
                .then(function(response) {
                    if (response.data.success) {
                        // Tutup modal jika perubahan password berhasil
                        $('#changepassword').modal('hide');
                        // Tampilkan pesan sukses dengan SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Password changed successfully',
                        });

                        // Reset formulir setelah berhasil mengganti kata sandi
                        form.trigger('reset');
                    } else {
                        // Tampilkan pesan kesalahan dengan SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: 'Password changed failed, please try again',
                        });

                        // Reset formulir setelah gagal mengganti kata sandi
                        form.trigger('reset');
                    }
                })
                .catch(function(error) {
                    // Tangani kesalahan jika terjadi
                    console.error(error);
                });
        }
    </script>

</body>

</html>