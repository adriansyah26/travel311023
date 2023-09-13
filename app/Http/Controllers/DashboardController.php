<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomer = Customer::count();

        $month = Carbon::now()->format('n');

        $totalInvoice = InvoiceItem::sum('total');
        $monthInvoice = InvoiceItem::wheremonth('created_at', $month)->sum('total');

        $invoices = Invoice::latest()->take(10)->get();

        return view('dashboard.index', compact('totalCustomer', 'totalInvoice', 'month', 'monthInvoice', 'invoices'));
    }
}
