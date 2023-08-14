@extends('layout.apps')
@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <hr>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card card-body bg-primary text-white mb-4">
                    <label>Total Customers</label>
                    <h1>{{$totalCustomer}}</h1>
                    <a href="{{url('customer')}}" class="small text-white">View</a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-body bg-warning text-white mb-4">
                    <label>Total Invoice</label>
                    <h1>{{$totalInvoice}}</h1>
                    <a href="{{url('invoiceitem')}}" class="small text-white">View</a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-body bg-success text-white mb-4">
                    <label>Month Invoice</label>
                    <h1>{{$monthInvoice}}</h1>
                    <a href="{{url('invoiceitem')}}" class="small text-white">View</a>
                </div>
            </div>
            <!-- <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">Invoice</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Success Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">Danger Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</main>

</html>
@endsection