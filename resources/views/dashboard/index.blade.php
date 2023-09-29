@extends('layout.apps')
@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
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
                        <i class="fa-solid fa-chart-pie"></i>
                        Pie Chart Total Invoice Items
                    </div>
                    <div style="width: 100%;">
                        <div class="card-body"><canvas id="piechart"></canvas></div>
                        <div class="card-footer small text-muted">Updated {{ $formattedLastUpdated }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fa-solid fa-chart-bar"></i>
                        Bar Chart Total Invoice Items For the Last 6 Months
                    </div>
                    <div style="width: 100%;">
                        <div class="card-body"><canvas id="barchart"></canvas></div>
                        <div class="card-footer small text-muted">Updated {{ $formattedLastUpdated }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-table"></i>
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
        const totalInvoice = <?php echo $totalInvoice; ?>; // Ambil nilai $totalInvoice dari Laravel
        const formattedTotalInvoice = totalInvoice.toLocaleString('id-ID', {
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
        const monthInvoice = <?php echo $monthInvoice; ?>; // Ambil nilai $monthInvoice dari Laravel
        const formattedMonthInvoice = monthInvoice.toLocaleString('id-ID', {
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
    const ctxpie = document.getElementById("piechart");
    const flightCount = <?php echo $flightCount; ?>;
    const trainCount = <?php echo $trainCount; ?>;
    const hotelCount = <?php echo $hotelCount; ?>;

    const piechart = new Chart(ctxpie, {
        type: 'pie',
        data: {
            labels: ['Flight', 'Train', 'Hotels'],
            datasets: [{
                data: [flightCount, trainCount, hotelCount],
                backgroundColor: ['rgba(0, 0, 255, 1)', 'rgba(255, 255, 0, 1)', 'rgba(255, 0, 0, 1)'],
                hoverBorderColor: ['rgba(0, 0, 0, 0)', 'rgba(0, 0, 0, 0)', 'rgba(0, 0, 0, 0)'], // Ubah warna border hover menjadi transparan
            }],
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


<script>
    const ctxbar = document.getElementById('barchart');
    const barchart = new Chart(ctxbar, {
        type: 'bar',
        data: {
            labels: <?= json_encode($monthLabels) ?>, // Menggunakan label bulan yang telah diambil dari PHP
            datasets: [{
                    label: 'Flight',
                    data: <?= json_encode($flightCounts) ?>, // Menggunakan data jumlah produk Flight
                    backgroundColor: 'rgba(0, 0, 255, 1)', // Biru
                    borderColor: 'rgba(0, 0, 255, 1)', // Biru
                    borderWidth: 1
                },
                {
                    label: 'Train',
                    data: <?= json_encode($trainCounts) ?>, // Menggunakan data jumlah produk Train
                    backgroundColor: 'rgba(255, 255, 0, 1)', // Kuning
                    borderColor: 'rgba(255, 255, 0, 1)', // Kuning
                    borderWidth: 1
                },
                {
                    label: 'Hotels',
                    data: <?= json_encode($hotelCounts) ?>, // Menggunakan data jumlah produk Hotel
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