<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $invoice = Invoice::latest()->get();

        return view('invoice.index', compact('invoice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Mendapatkan invoice terakhir
        $lastInvoice = Invoice::latest('id')->first();

        if ($lastInvoice) {
            $lastInvoiceNumber = $lastInvoice->invoice_number;
            $nextInvoiceNumber = intval(substr($lastInvoiceNumber, strpos($lastInvoiceNumber, '/') + 1)) + 1;
        } else {
            $nextInvoiceNumber = 1;
        }
        $romawi = [
            1 => '/I', '/II', '/III', '/IV', '/V', '/VI', '/VII', '/VIII', '/IX', '/X', '/XI', '/XII'
        ];

        // Gabungkan dengan awalan "INV/" untuk mendapatkan nomor invoice lengkap
        $nextInvoiceNumberFull = 'INV/' . str_pad($nextInvoiceNumber, 2, '0', STR_PAD_LEFT) . $romawi[now()->format('n')] . '/KSP/' . now()->format('Y');

        $customers = Customer::all();

        $products = Product::all();

        return view('invoice.create', compact('products', 'customers', 'nextInvoiceNumberFull'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required',
            'customer_id' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $invoice_number = $request->input('invoice_number');
            // Simpan data invoice items ke dalam database
            $invoice = Invoice::create([
                'invoice_number' => $request->input('invoice_number'),
                'customer_id' => $request->input('customer_id'),
                'status' => $request->input('status'),
            ]);

            DB::commit();

            $invoice_item = Invoice::select('id')->where('invoice_number', $invoice_number)->first();
            return response()->json([
                'success' => true,
                'items' => $invoice_item,
                'messages' => "Invoice created successfully"
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors(['error' => 'Failed created invoice'])
                ->withInput();
        }
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'invoice_number' => 'required',
    //         'customer_id' => 'required',
    //         'status' => 'required',
    //         'product' => 'required|array',
    //         'product.*' => 'exists:products,name',
    //         'item' => 'required|array',
    //         'description' => 'required|array',
    //         'quantity' => 'required|array',
    //         'quantity.*' => 'integer|min:1',
    //         'amount' => 'required|array',
    //         'amount.*' => 'numeric|min:0',
    //         'markup' => 'required|array',
    //         'markup.*' => 'numeric|min:0',
    //         'total' => 'required|array',
    //         'total.*' => 'numeric|min:0',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     try {
    //         DB::beginTransaction();

    //         // Simpan data invoice items
    //         $invoiceItemsData = [];
    //         $products = $request->input('product');
    //         $items = $request->input('item');
    //         $descriptions = $request->input('description');
    //         $quantities = $request->input('quantity');
    //         $amounts = $request->input('amount');
    //         $markups = $request->input('markup');
    //         $totals = $request->input('total');

    //         for ($i = 0; $i < count($products); $i++) {
    //             $invoiceItemsData[] = [
    //                 'product' => $products[$i],
    //                 'item' => $items[$i],
    //                 'description' => $descriptions[$i],
    //                 'quantity' => $quantities[$i],
    //                 'amount' => $amounts[$i],
    //                 'markup' => $markups[$i],
    //                 'total' => $totals[$i],
    //             ];
    //         }

    //         // Simpan data invoice items ke dalam database
    //         $invoice = Invoice::create([
    //             'invoice_number' => $request->input('invoice_number'),
    //             'customer_id' => $request->input('customer_id'),
    //             'status' => $request->input('status', false),
    //         ]);

    //         $invoice->invoiceitem()->createMany($invoiceItemsData);

    //         DB::commit();

    //         return redirect()->route('invoice.index')
    //             ->with('success', 'Invoice created successfully');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()
    //             ->withErrors(['error' => 'Failed created invoice'])
    //             ->withInput();
    //     }
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        // return view('invoice.pdf', compact('invoice'));

        $pdf = FacadePdf::loadView('invoice.pdf', compact('invoice'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream();

        // return $pdf->download('invoice.pdf');
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
            'invoice_number' => 'required',
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

    public function saveItems(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required|exists:invoices,id',
            'product' => 'required',
            'product.*' => 'exists:products,name',
            'item' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'quantity.*' => 'numeric|min:1',
            'amount' => 'required',
            'amount.*' => 'numeric|min:0',
            'markup' => 'required',
            'markup.*' => 'numeric|min:0',
            'total' => 'required',
            'total.*' => 'numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        try {
            DB::beginTransaction();

            $invoiceId = $request->input('invoice_id');
            $products = $request->input('product');
            $items = $request->input('item');
            $descriptions = $request->input('description');
            $quantities = $request->input('quantity');
            $amounts = $request->input('amount');
            $markups = $request->input('markup');
            $totals = $request->input('total');

            // Simpan data invoice items ke dalam database
            $invoiceItemsData = InvoiceItem::create([
                'invoice_id' => $invoiceId,
                'product' => $products,
                'item' => $items,
                'description' => $descriptions,
                'quantity' => $quantities,
                'amount' => $amounts,
                'markup' => $markups,
                'total' => $totals,
            ]);
            DB::commit();

            // Pastikan item berhasil disimpan sebelum mengambilnya kembali
            if ($invoiceItemsData) {
                $invoice_item = InvoiceItem::where('invoice_id', $invoiceId)->get();
                return response()->json([
                    'success' => true,
                    'items' => $invoice_item,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save items.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save items: ' . $e->getMessage(),
            ]);
        }
    }

    public function editItems($itemId)
    {
        $item = InvoiceItem::findOrFail($itemId);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found.',
            ]);
        }

        return response()->json([
            'success' => true,
            'item' => $item,
        ]);
    }

    public function updateItems(Request $request, $itemId)
    {
        $validator = Validator::make($request->all(), [
            'productedit' => 'required',
            'itemedit' => 'required',
            'descriptionedit' => 'required',
            'quantityedit' => 'required|numeric|min:1',
            'amountedit' => 'required|numeric|min:0',
            'markupedit' => 'required|numeric|min:0',
            'totaledit' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        try {
            DB::beginTransaction();

            $item = InvoiceItem::findOrFail($itemId);

            $item->product = $request->input('productedit');
            $item->item = $request->input('itemedit');
            $item->description = $request->input('descriptionedit');
            $item->quantity = $request->input('quantityedit');
            $item->amount = $request->input('amountedit');
            $item->markup = $request->input('markupedit');
            $item->total = $request->input('totaledit');

            $item->save();

            DB::commit();

            $updatedItem = InvoiceItem::findOrFail($itemId);

            return response()->json([
                'success' => true,
                'message' => 'Item updated successfully.',
                'item' => $updatedItem, // Include the updated item in the response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update item: ' . $e->getMessage(),
            ]);
        }
    }
}
