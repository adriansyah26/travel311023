<!DOCTYPE html>
<html lang="en">
@include('include.title')

<body>
    @include('include.navbar')
    @yield('content')

    <!-- endcontent -->
    <!-- <footer class="py-4 bg-light mt-auto">
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
    </footer> -->

    @include('include.script')
    @stack('scripts')
</body>

</html>