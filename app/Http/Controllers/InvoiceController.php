<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
            Invoice::create([
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($invoiceId)
    {
        // Ambil data invoice berdasarkan ID
        $invoice = Invoice::findOrFail($invoiceId);

        // Ambil data item terkait dengan invoice
        $invoiceItems = InvoiceItem::where('invoice_id', $invoiceId)->get();

        // penjumlahan otomatis
        $subtotalInvoice = InvoiceItem::where('invoice_id', $invoiceId)->get()->sum('total');
        $servicefeeInvoice = InvoiceItem::where('invoice_id', $invoiceId)->get()->sum('service_fee');
        $grandtotalInvoice = InvoiceItem::where('invoice_id', $invoiceId)->sum(DB::raw('total + service_fee'));

        $products = Product::all();

        // tanggal otomatis berdasrkan invoice dibuat
        $tanggalInvoice = $invoice->created_at;

        $bulan = [
            1 => ' Januari ', ' Februari ', ' Maret ', ' April ', ' Mei ', ' Juni ', ' Juli ', ' Agustus ', ' September ', ' Oktober ', ' November ', ' Desember '
        ];

        $formattanggal = $tanggalInvoice->format('j') . $bulan[$tanggalInvoice->format('n')] . $tanggalInvoice->format('Y');

        $pdf = FacadePdf::loadView('invoice.pdf', compact('invoice', 'invoiceItems', 'formattanggal', 'products', 'subtotalInvoice', 'servicefeeInvoice', 'grandtotalInvoice'));
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
    public function edit($invoiceId)
    {
        try {
            // Ambil data invoice berdasarkan ID
            $invoice = Invoice::findOrFail($invoiceId);

            // Ambil data item terkait dengan invoice
            $invoiceItems = InvoiceItem::where('invoice_id', $invoiceId)->get();
            $products = Product::all();
            $customers = Customer::all();

            // Kembalikan view edit dengan data invoice dan item yang terkait
            return view('invoice.edit', compact('invoice', 'invoiceItems', 'products', 'customers'));
        } catch (\Exception $e) {
            // Tangani jika terjadi kesalahan
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat mengambil data invoice'])->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $invoiceId)
    {
        // Validasi input
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

            // Cari faktur berdasarkan ID
            $invoice = Invoice::find($invoiceId);

            if (!$invoice) {
                return redirect()->back()
                    ->withErrors(['error' => 'Invoice not found'])
                    ->withInput();
            }

            // Perbarui propertinya
            $invoice->invoice_number = $request->input('invoice_number');
            $invoice->customer_id = $request->input('customer_id');
            $invoice->status = $request->input('status');
            $invoice->save();

            DB::commit();

            // Kembalikan respons JSON jika perlu
            return response()->json([
                'success' => true,
                'messages' => "Invoice updated successfully"
            ]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi rollback
            DB::rollback();

            return redirect()->back()
                ->withErrors(['error' => 'Failed to update invoice'])
                ->withInput();
        }
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

    // untuk menyimpan invoiceitem dihalaman create
    public function saveItems(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required|exists:invoices,id',
            'product_id' => 'required',
            'product_id.*' => 'exists:products,name',
            'item' => 'required',
            'kode_booking' => 'required',
            'description' => 'required',
            'markup' => 'required',
            'markup.*' => 'numeric|min:0',
            'quantity' => 'required',
            'quantity.*' => 'numeric|min:1',
            'amount' => 'required',
            'amount.*' => 'numeric|min:0',
            'service_fee' => 'required',
            'service_fee.*' => 'numeric|min:0',
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
            $productId = $request->input('product_id');
            $items = $request->input('item');
            $kode_bookings = $request->input('kode_booking');
            $descriptions = $request->input('description');
            $quantities = $request->input('quantity');
            $amounts = $request->input('amount');
            $markups = $request->input('markup');
            $service_fees = $request->input('service_fee');
            $totals = $request->input('total');

            // Simpan data invoice items ke dalam database
            $invoiceItemsData = InvoiceItem::create([
                'invoice_id' => $invoiceId,
                'product_id' => $productId,
                'item' => $items,
                'kode_booking' => $kode_bookings,
                'description' => $descriptions,
                'quantity' => preg_replace('/[.,]/', '', $quantities),
                'amount' => preg_replace('/[.,]/', '', $amounts),
                'markup' => preg_replace('/[.,]/', '', $markups),
                'service_fee' => preg_replace('/[.,]/', '', $service_fees),
                'total' => preg_replace('/[.,]/', '', $totals),
            ]);
            DB::commit();

            // Pastikan item berhasil disimpan sebelum mengambilnya kembali
            if ($invoiceItemsData) {
                $invoice_item = InvoiceItem::where('invoice_id', $invoiceId)->get();
                return response()->json([
                    'success' => true,
                    'items' => $invoice_item,
                    'messages' => 'Invoice item created successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'messages' => 'Failed to save items.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save items: ' . $e->getMessage(),
            ]);
        }
    }

    // untuk mengambil id table invoiceitem dihalaman create
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

    // untuk menyimpan update invoiceitem dihalaman create
    public function updateItems(Request $request, $itemId)
    {
        $validator = Validator::make($request->all(), [
            'product_id_edit' => 'required',
            'itemedit' => 'required',
            'kode_bookingedit' => 'required',
            'descriptionedit' => 'required',
            'markupedit' => 'required',
            'markupedit.*' => 'numeric|min:0',
            'quantityedit' => 'required',
            'quantityedit.*' => 'numeric|min:1',
            'amountedit' => 'required',
            'amountedit.*' => 'numeric|min:0',
            'service_feeedit' => 'required',
            'service_feeedit.*' => 'numeric|min:0',
            'totaledit' => 'required',
            'totaledit.*' => 'numeric|min:0',
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

            $item->product_id = $request->input('product_id_edit');
            $item->item = $request->input('itemedit');
            $item->kode_booking = $request->input('kode_bookingedit');
            $item->description = $request->input('descriptionedit');
            $item->quantity = preg_replace('/[.,]/', '', $request->input('quantityedit'));
            $item->amount = preg_replace('/[.,]/', '', $request->input('amountedit'));
            $item->markup = preg_replace('/[.,]/', '', $request->input('markupedit'));
            $item->service_fee = preg_replace('/[.,]/', '', $request->input('service_feeedit'));
            $item->total = preg_replace('/[.,]/', '', $request->input('totaledit'));

            $item->save();

            DB::commit();

            $updatedItem = InvoiceItem::findOrFail($itemId);

            return response()->json([
                'success' => true,
                'messages' => 'Invoice item updated successfully',
                'item' => $updatedItem, // Include the updated item in the response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update item: ' . $e->getMessage(),
            ]);
        }
    }

    // untuk mengambil id table invoiceitem dihalaman edit
    public function editItemsedit($itemId)
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

    // untuk menyimpan update invoiceitem dihalaman edit
    public function updateItemsupdate(Request $request, $itemId)
    {
        // Validasi data yang diterima dari formulir jika diperlukan
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'item' => 'required',
            'kode_booking' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'quantity.*' => 'numeric|min:1',
            'amount' => 'required',
            'amount.*' => 'numeric|min:0',
            'markup' => 'required',
            'markup.*' => 'numeric|min:0',
            'service_fee' => 'required',
            'service_fee.*' => 'numeric|min:0',
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

            $item = InvoiceItem::findOrFail($itemId);

            $item->product_id = $request->input('product_id');
            $item->item = $request->input('item');
            $item->kode_booking = $request->input('kode_booking');
            $item->description = $request->input('description');
            $item->quantity = preg_replace('/[.,]/', '', $request->input('quantity'));
            $item->amount = preg_replace('/[.,]/', '', $request->input('amount'));
            $item->markup = preg_replace('/[.,]/', '', $request->input('markup'));
            $item->service_fee = preg_replace('/[.,]/', '', $request->input('service_fee'));
            $item->total = preg_replace('/[.,]/', '', $request->input('total'));

            $item->save();

            DB::commit();

            $updatedItem = InvoiceItem::findOrFail($itemId);

            return response()->json([
                'success' => true,
                'messages' => 'Invoice item updated successfully',
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
