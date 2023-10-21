<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil jumlah customer
        $totalCustomer = Customer::count();

        // Ambil total invoiceitem
        $totalInvoice = InvoiceItem::sum(DB::raw('total + service_fee'));

        // Ambil total invoiceitem berdasarkan bulan
        $month = Carbon::now()->format('n');
        $monthInvoice = InvoiceItem::wheremonth('created_at', $month)->sum(DB::raw('total + service_fee'));

        // Ambil table invoice 10 terakhir
        $invoices = Invoice::latest()->take(10)->get();

        // Ambil data invoiceitem berdasarkan product_id pie charts
        $invoiceItems = InvoiceItem::all();

        // Inisialisasi jumlah produk
        $flightCount = 0;
        $trainCount = 0;
        $hotelCount = 0;
        $rentalCount = 0;

        // Hitung jumlah produk berdasarkan nama produk yang mengandung "FLIGHT," "TRAIN," atau "HOTEL"
        foreach ($invoiceItems as $item) {
            $product = Product::find($item->product_id);

            if ($product) {
                $productName = strtolower($product->name);

                // Pencarian kata "FLIGHT" atau "PESAWAT"
                if (stripos($productName, 'FLIGHT') !== false || stripos($productName, 'PESAWAT') !== false) {
                    $flightCount++;
                }

                // Pencarian kata "TRAIN" atau "KERETA"
                if (stripos($productName, 'TRAIN') !== false || stripos($productName, 'KERETA') !== false) {
                    $trainCount++;
                }

                // Pencarian kata "HOTELS" atau "HOTEL"
                if (stripos($productName, 'HOTELS') !== false || stripos($productName, 'HOTEL') !== false) {
                    $hotelCount++;
                }

                // Pencarian kata "RENTAL" atau "SEWA"
                if (stripos($productName, 'RENTAL') !== false || stripos($productName, 'SEWA') !== false) {
                    $rentalCount++;
                }
            }
        }

        // bar charts
        $endDate = Carbon::now()->endOfMonth(); // Akhir bulan saat ini

        // Hitung tanggal awal 6 bulan yang lalu
        $startDate = Carbon::now()->subMonths(5)->startOfMonth();

        $flightCounts = [];
        $trainCounts = [];
        $hotelCounts = [];
        $rentalCounts = [];
        $monthLabels = [];

        while ($startDate->lte($endDate)) { // Loop sampai tanggal awal lebih besar dari tanggal akhir
            $monthLabels[] = $startDate->format('F'); // Label bulan, misalnya 'January', 'February', dsb.

            // Ambil data invoice item untuk bulan saat ini
            $invoiceItemsMonth = InvoiceItem::whereMonth('created_at', $startDate->month)
                ->whereYear('created_at', $startDate->year)
                ->get();

            $flightCountMonth = 0;
            $trainCountMonth = 0;
            $hotelCountMonth = 0;
            $rentalCountMonth = 0;

            foreach ($invoiceItemsMonth as $itemMonth) {
                $product = Product::find($itemMonth->product_id);

                if ($product) {
                    $productNameMonth = strtolower($product->name);

                    // Pencarian kata "FLIGHT" atau "PESAWAT"
                    if (stripos($productNameMonth, 'FLIGHT') !== false || stripos($productNameMonth, 'PESAWAT') !== false) {
                        $flightCountMonth++;
                    }

                    // Pencarian kata "TRAIN" atau "KERETA"
                    if (stripos($productNameMonth, 'TRAIN') !== false || stripos($productNameMonth, 'KERETA') !== false) {
                        $trainCountMonth++;
                    }

                    // Pencarian kata "HOTELS" atau "HOTEL"
                    if (stripos($productNameMonth, 'HOTELS') !== false || stripos($productNameMonth, 'HOTEL') !== false) {
                        $hotelCountMonth++;
                    }

                    // Pencarian kata "RENTAL" atau "SEWA"
                    if (stripos($productNameMonth, 'RENTAL') !== false || stripos($productNameMonth, 'SEWA') !== false) {
                        $rentalCountMonth++;
                    }
                }
            }

            $flightCounts[] = $flightCountMonth;
            $trainCounts[] = $trainCountMonth;
            $hotelCounts[] = $hotelCountMonth;
            $rentalCounts[] = $rentalCountMonth;

            // Lanjutkan ke bulan berikutnya
            $startDate->addMonth();
        }

        // mengambil invoiceitem terbaru update charts
        $latestInvoiceItem = InvoiceItem::latest()->first();

        // Memformat tanggal pembuatan invoiceitem
        if ($latestInvoiceItem) {
            $formattedLastUpdated = $latestInvoiceItem->updated_at->format('d F Y \a\t h:i A');
        } else {
            $formattedLastUpdated = 'N/A'; // Tampilkan 'N/A' jika tidak ada invoiceitem
        }

        return view('dashboard.index', compact('totalCustomer', 'totalInvoice', 'month', 'monthInvoice', 'invoices', 'flightCount', 'trainCount', 'hotelCount', 'rentalCount', 'flightCounts', 'trainCounts', 'hotelCounts', 'rentalCounts', 'monthLabels', 'formattedLastUpdated'));
    }
}
