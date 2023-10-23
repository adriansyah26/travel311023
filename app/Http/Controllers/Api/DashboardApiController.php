<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardApiController extends Controller
{
    public function index()
    {
        try {
            // Ambil jumlah customer
            $totalCustomer = Customer::count();

            // Ambil total invoiceitem
            $totalInvoice = InvoiceItem::sum(DB::raw('total + service_fee'));

            // Ambil total invoiceitem berdasarkan bulan
            $month = Carbon::now()->format('n');
            $monthInvoice = InvoiceItem::whereMonth('created_at', $month)->sum(DB::raw('total + service_fee'));

            // Ambil table invoice 10 terakhir
            $invoices = Invoice::latest()
                ->take(10)
                ->withCount(['invoiceitem as total_invoice_item' => function ($query) {
                    $query->select(DB::raw('sum(total + service_fee)'));
                }])
                ->get();

            // Ambil data invoiceitem berdasarkan product_id untuk pie charts
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

            // Bar charts
            $endDate = Carbon::now()->endOfMonth();
            $startDate = Carbon::now()->subMonths(5)->startOfMonth();
            $flightCounts = [];
            $trainCounts = [];
            $hotelCounts = [];
            $rentalCounts = [];
            $monthLabels = [];

            while ($startDate->lte($endDate)) {
                $monthLabels[] = $startDate->format('F');

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

            // Mengambil invoiceitem terbaru untuk update charts
            $latestInvoiceItem = InvoiceItem::latest()->first();
            $formattedLastUpdated = $latestInvoiceItem ? $latestInvoiceItem->updated_at->format('d F Y \a\t h:i A') : 'N/A';

            $data = [
                'totalCustomer' => $totalCustomer,
                'totalInvoice' => $totalInvoice,
                'month' => $month,
                'monthInvoice' => $monthInvoice,
                'flightCount' => $flightCount,
                'trainCount' => $trainCount,
                'hotelCount' => $hotelCount,
                'rentalCount' => $rentalCount,
                'flightCounts' => $flightCounts,
                'trainCounts' => $trainCounts,
                'hotelCounts' => $hotelCounts,
                'rentalCounts' => $rentalCounts,
                'monthLabels' => $monthLabels,
                'formattedLastUpdated' => $formattedLastUpdated,
                'invoices' => $invoices,
            ];

            return Api::json($data, 200, 'Success to retrieve dashboard data', true);
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to retrieve dashboard data', false);
        }
    }
}
