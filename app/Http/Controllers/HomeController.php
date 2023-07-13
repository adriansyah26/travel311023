<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $totalCustomer = Customer::count();

        $month = Carbon::now()->format('n');

        $totalInvoice = Invoice::sum('total');
        $monthInvoice = Invoice::wheremonth('created_at', $month)->sum('total');

        return view('home', compact('totalCustomer', 'totalInvoice', 'month', 'monthInvoice'));
    }
}
