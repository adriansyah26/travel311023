<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InvoiceApiController extends Controller
{
    public function index()
    {
        try {
            $invoices = Invoice::latest()->get();

            return Api::json($invoices, 200, 'Invoice retrieved successfully', true);
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to retrieve invoice', false);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_number' => ['required', 'unique:invoices,invoice_number'],
            'customer_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return Api::json([], 400, 'Validation error', false, ['errors' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();

            $invoice = Invoice::create([
                'invoice_number' => $request->input('invoice_number'),
                'customer_id' => $request->input('customer_id'),
                'status' => $request->input('status'),
            ]);

            DB::commit();

            return Api::json($invoice, 201, 'Invoice created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return Api::json([], 500, 'Failed created invoice', false);
        }
    }

    public function show($invoiceId)
    {
        try {
            // Ambil data invoice berdasarkan ID
            $invoice = Invoice::findOrFail($invoiceId);

            if (!$invoice) {
                return Api::json([], 404, 'Invoice not found', false);
            }

            // Ambil data item terkait dengan invoice
            $invoiceItems = InvoiceItem::where('invoice_id', $invoiceId)->get();

            // penjumlahan otomatis
            $subtotalInvoice = InvoiceItem::where('invoice_id', $invoiceId)->get()->sum('total');
            $servicefeeInvoice = InvoiceItem::where('invoice_id', $invoiceId)->get()->sum('service_fee');
            $grandtotalInvoice = InvoiceItem::where('invoice_id', $invoiceId)->sum(DB::raw('total + service_fee'));

            // tanggal otomatis berdasarkan invoice dibuat
            $tanggalInvoice = $invoice->created_at;

            $bulan = [
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            $formattanggal = $tanggalInvoice->format('j') . ' ' . $bulan[$tanggalInvoice->format('n')] . ' ' . $tanggalInvoice->format('Y');

            // Format data yang akan dijadikan JSON
            $data = [
                'invoice' => $invoice,
                'invoiceItems' => $invoiceItems,
                'subtotalInvoice' => $subtotalInvoice,
                'servicefeeInvoice' => $servicefeeInvoice,
                'grandtotalInvoice' => $grandtotalInvoice,
                'formattanggal' => $formattanggal,
            ];

            return Api::json($data, 200, 'Success to retrieve invoice', true);
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to retrieve invoice', false);
        }
    }

    public function update(Request $request, $invoiceId)
    {
        $validator = Validator::make($request->all(), [
            'invoice_number' => ['required', Rule::unique('invoices', 'invoice_number')->ignore($invoiceId)],
            'customer_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return Api::json([], 400, 'Validation error', false, ['errors' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();

            $invoice = Invoice::find($invoiceId);

            if (!$invoice) {
                return Api::json([], 404, 'Invoice not found', false);
            }

            $invoice->invoice_number = $request->input('invoice_number');
            $invoice->customer_id = $request->input('customer_id');
            $invoice->status = $request->input('status');
            $invoice->save();

            DB::commit();

            return Api::json($invoice, 200, 'Invoice updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return Api::json([], 500, 'Failed updated invoice', false);
        }
    }

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
            return Api::json([], 400, 'Validation error', false, ['errors' => $validator->errors()]);
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
                'quantity' =>  $quantities,
                'amount' =>  $amounts,
                'markup' =>  $markups,
                'service_fee' =>  $service_fees,
                'total' =>  $totals,
            ]);

            DB::commit();

            // Pastikan item berhasil disimpan sebelum mengambilnya kembali
            if ($invoiceItemsData) {
                $invoice_item = InvoiceItem::where('invoice_id', $invoiceId)->get();
                $data = [
                    'items' => $invoice_item,
                    'messages' => 'Invoice item created successfully',
                ];
                return Api::json($data, 200, 'Success created invoice item', true);
            } else {
                return Api::json([], 500, 'Failed save item', false);
            }
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed save item' . $e->getMessage(), false);
        }
    }

    public function showItems($itemId)
    {
        try {
            $invoiceItems = InvoiceItem::where('id', $itemId)->first();

            if ($invoiceItems) {
                return Api::json($invoiceItems, 200, 'Invoice items retrieved successfully', true);
            } else {
                return Api::json([], 404, 'Invoice item not found', false);
            }
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to retrieve invoice item' . $e->getMessage(), false);
        }
    }

    public function updateItems(Request $request, $itemId)
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
            return Api::json([], 400, 'Validation error', false, ['errors' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();

            $item = InvoiceItem::findOrFail($itemId);

            if (!$item) {
                return Api::json([], 404, 'invoice item not found', false);
            }

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

            return Api::json($updatedItem, 200, 'Invoice item updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return Api::json([], 500, 'Failed to update item' . $e->getMessage(), false);
        }
    }
}
