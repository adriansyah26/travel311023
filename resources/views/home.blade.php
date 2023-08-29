@extends('layout.apps')
@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <!-- <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol> -->
        <hr>
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="card card-body bg-primary text-white mb-4">
                    <label>Total Customers</label>
                    <div>
                        <i class="fa-solid fa-users" style="display: inline-block; vertical-align: middle; font-size: 30px;">></i>
                        <h3 style="display: inline-block; vertical-align: middle;">{{$totalCustomer}}</h3>
                    </div>
                    <a href="{{url('customer')}}" class="small text-white">View</a>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card card-body bg-warning text-white mb-4">
                    <label>Total Invoice</label>
                    <div>
                        <i class="fa-solid fa-wallet" style="display: inline-block; vertical-align: middle; font-size: 30px;"></i>
                        <h3 id="formattedTotalInvoice" style="display: inline-block; vertical-align: middle;"></h3>
                    </div>
                    <a href="{{url('invoice')}}" class="small text-white">View</a>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card card-body bg-success text-white mb-4">
                    <label>Month Invoice</label>
                    <div>
                        <i class="fa-solid fa-money-bills" style="display: inline-block; vertical-align: middle; font-size: 30px;"></i>
                        <h3 id="formattedMonthInvoice" style="display: inline-block; vertical-align: middle;"></h3>
                    </div>
                    <a href="{{url('invoice')}}" class="small text-white">View</a>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var totalInvoice = <?php echo $totalInvoice; ?>; // Ambil nilai $totalInvoice dari Laravel
        var formattedTotalInvoice = totalInvoice.toLocaleString('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        });

        // Menyimpan hasil format ke dalam elemen HTML
        document.getElementById('formattedTotalInvoice').textContent = formattedTotalInvoice;
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var monthInvoice = <?php echo $monthInvoice; ?>; // Ambil nilai $monthInvoice dari Laravel
        var formattedMonthInvoice = monthInvoice.toLocaleString('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        });

        // Menyimpan hasil format ke dalam elemen HTML
        document.getElementById('formattedMonthInvoice').textContent = formattedMonthInvoice;
    });
</script>
@endsection