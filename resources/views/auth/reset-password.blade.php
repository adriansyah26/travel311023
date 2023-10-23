<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="icon" href="/image/titledanmenu.png">
    <title>Reset Password</title>
</head>

<body class="bg-white">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container" style="margin-top: 60px;">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4"><img style="width: 60px;" src="/image/titledanmenu.png"> Reset Password</h3>
                                </div>

                                <div class="card-body">
                                    @if ($errors->any ())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    @if (session()->has('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session()->get('status') }}
                                    </div>
                                    @endif

                                    <form method="POST" action="{{ route('password.update')}}">
                                        @csrf

                                        <input type="hidden" name="token" value="{{ request()->token }}">
                                        <input type="hidden" name="email" value="{{ request()->email }}">

                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="New Password" required autocomplete="new-password">
                                            <label for="inputPassword">New Password</label>
                                            <span id="togglePassword" class="bi bi-eye position-absolute top-50 translate-middle-y" style="cursor: pointer; margin-left: 390px;"></span>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Conform New Password" required autocomplete="new-password">
                                            <label for="inputPassword">Confirm New Password</label>
                                            <span id="togglePasswordConfirm" class="bi bi-eye position-absolute top-50 translate-middle-y" style="cursor: pointer; margin-left: 390px;"></span>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary">Reset Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePassword.classList.remove('bi-eye');
                togglePassword.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                togglePassword.classList.remove('bi-eye-slash');
                togglePassword.classList.add('bi-eye');
            }
        });

        // Inisialisasi input password sebagai tipe password
        passwordInput.type = 'password';
    </script>

    <script>
        const passwordInputconfirm = document.getElementById('password_confirmation');
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');

        togglePasswordConfirm.addEventListener('click', function() {
            if (passwordInputconfirm.type === 'password') {
                passwordInputconfirm.type = 'text';
                togglePasswordConfirm.classList.remove('bi-eye');
                togglePasswordConfirm.classList.add('bi-eye-slash');
            } else {
                passwordInputconfirm.type = 'password';
                togglePasswordConfirm.classList.remove('bi-eye-slash');
                togglePasswordConfirm.classList.add('bi-eye');
            }
        });

        // Inisialisasi input password sebagai tipe password
        passwordInputconfirm.type = 'password';
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>