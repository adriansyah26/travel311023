<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Str;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Barryvdh\DomPDF\Facade as PDF;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $invoice = Invoice::latest()->paginate(10);

        return view('invoice.index', compact('invoice'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();

        $products = Product::all();

        return view('invoice.create', compact('products', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validRequest = $request->validate([
            // 'invoice_number' => 'required',
            'customer_id' => 'required',
            'product' => 'required',
            'item' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'amount' => 'required',
            'markup' => 'required',
            'total' => 'required',
            'status' => 'required',
        ]);

        $customerId = $request->input('customer_id');

        // Cek apakah customer_id sudah memiliki invoice terkait
        if (Invoice::where('customer_id', $customerId)->exists()) {
            return redirect()->back()->withErrors('Customers_Name already has an invoice.');
        }

        Invoice::create($validRequest);

        return redirect()->route('invoice.index')
            ->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return view('invoice.show', compact('invoice'));

        $pdf = PDF::loadView('invoice_pdf');

        return $pdf->download('invoice.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        return view('invoice.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            // 'invoice_number' => 'required',
            'customer_id' => 'required',
            'product' => 'required',
            'item' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'amount' => 'required',
            'markup' => 'required',
            'total' => 'required',
            'status' => 'required',
        ]);

        $invoice->update($request->all());

        return redirect()->route('invoice.index')
            ->with('success', 'Invoice updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoice.index')
            ->with('success', 'Invoice deleted successfully');
    }
}
