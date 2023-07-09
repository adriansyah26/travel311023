<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

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
        return view('invoice.create');
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
            'product' => 'required',
            'item' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'amount' => 'required',
            'markup' => 'required',
            'total' => 'required',
            'status' => 'required',
        ]);

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

        return $pdf->download('techsolutionstuff.pdf');
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
