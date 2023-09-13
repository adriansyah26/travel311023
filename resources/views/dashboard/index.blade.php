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
                    <label>Total Month Invoice</label>
                    <div>
                        <i class="fa-solid fa-money-bills" style="display: inline-block; vertical-align: middle; font-size: 30px;"></i>
                        <h3 id="formattedMonthInvoice" style="display: inline-block; vertical-align: middle;"></h3>
                    </div>
                    <a href="{{url('invoice')}}" class="small text-white">View</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Line Chart
                    </div>
                    <div style="width: 100%; margin: 0 auto;">
                        <canvas id="linechart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Bar Chart
                    </div>
                    <div style="width: 100%; margin: 0 auto;">
                        <canvas id="barchart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Last 10 DataTable Invoice
            </div>
            <div class="card-body" style="overflow-x: auto;">
                <table id="table" class="table  table-striped table-bordered" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <th style="width: 30px;">No</th>
                            <th style="width: 150px;">Invoice Number</th>
                            <th style="width: 465px;">Customers Name</th>
                            <th style="width: 100px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $i => $invoice)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->customer->name }}</td>
                            <td>{{ number_format($invoice->invoiceitem->sum('total'), 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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

<script>
    var ctx = document.getElementById('linechart').getContext('2d');
    var linechart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                    label: 'Flight',
                    data: [10, 15, 20, 25, 30],
                    backgroundColor: 'rgba(0, 0, 255, 1)', // Biru
                    borderColor: 'rgba(0, 0, 255, 1)', // Biru
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Train',
                    data: [5, 10, 15, 20, 25],
                    backgroundColor: 'rgba(255, 255, 0, 1)', // Kuning
                    borderColor: 'rgba(255, 255, 0, 1)', // Kuning
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Hotel',
                    data: [15, 20, 25, 30, 35],
                    backgroundColor: 'rgba(255, 0, 0, 1)', // Merah
                    borderColor: 'rgba(255, 0, 0, 1)', // Merah
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById('barchart').getContext('2d');
    var barchart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                    label: 'Flight',
                    data: [10, 15, 20, 25, 30],
                    backgroundColor: 'rgba(0, 0, 255, 1)', // Biru
                    borderColor: 'rgba(0, 0, 255, 1)', // Biru
                    borderWidth: 1
                },
                {
                    label: 'Train',
                    data: [5, 10, 15, 20, 25],
                    backgroundColor: 'rgba(255, 255, 0, 1)', // Kuning
                    borderColor: 'rgba(255, 255, 0, 1)', // Kuning
                    borderWidth: 1
                },
                {
                    label: 'Hotel',
                    data: [15, 20, 25, 30, 35],
                    backgroundColor: 'rgba(255, 0, 0, 1)', // Merah
                    borderColor: 'rgba(255, 0, 0, 1)', // Merah
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>



@endsection