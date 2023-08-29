<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="{{ public_path('image/travellogo2.png') }}">
    <title>K - Tour & Travel</title>
    <link rel="stylesheet" href="{{ public_path('css/style.css') }}" media="all" />
</head>

<body>
    <header class="clearfix">
        <div id="company">
            <div>PT KAMAIRA SOLUSI PRATAMA</div>
            <div>Casa Verde Building 4rd Floor</div>
            <div>Jl Mampang Prapatan Nomor 17 K</div>
            <div>Jakarta Selatan, 12790 Indonesia</div>
            <!-- <div><a href="mailto:company@example.com">company@example.com</a></div> -->
        </div>
    </header>
    <div>
        <div id="logo" style="margin-top: -30px;">
            <img src="{{ public_path('image/travellogo3.png') }}" alt="image invoice" style="width:150px;height:100px;">
        </div>
    </div>
    <hr style="margin-left: 150px; margin-right: 100px; border: 1px solid black;">
    <main>
        <div id="details" class="clearfix" style="margin-right: 100px;">
            <div id="invoice">
                <div style="margin-top: 30px; margin-right: 60px;">INVOICE</div>
                <div style="margin-left: 100px;">{{ $invoice->invoice_number }}</div>
            </div>
            <div style="border-top: 4px outset#0000FF; margin-right: 480px; margin-top: -20px;"> </div>
            <hr style="margin-right: 480px; border: 1px solid #00008B;">
        </div>
        <div style="border-top: 4px outset#0000FF; margin-right: 100px; margin-left: 500px; margin-top: -33px; "> </div>
        <hr style="margin-right: 100px; margin-left: 500px; border: 1px solid #00008B;">
        <div id="rounded1" style="margin-top: 30px; margin-bottom: 20px;">
            <div style="margin-bottom: 5px; margin-left: 70px; margin-top: -20px; font-weight:bold">Customers</div>
            <div style="margin-left: -15px;">Nama </div>
            <div style="margin-left: 23px; margin-top: -12px;"> : </div>
            <div style="margin-left: 29px; margin-top: -12px;">{{ $invoice->customer->name }}</div>
            <div style="margin-left: -15px">Alamat </div>
            <div style="margin-left: 23px; margin-top: -12px;"> : </div>
            <div style="margin-left: 29px; margin-top: -12px;">{{ $invoice->customer->address }}</div>
            <div style="margin-left: -15px">Note </div>
            <div style="margin-left: 23px; margin-top: -12px;"> : </div>
            <div style="margin-left: 29px; margin-top: -12px; font-weight:bold">
                @foreach ($invoiceItems->unique('product_id') as $item)
                @php
                $productName = $item->product_id ? $products->find($item->product_id)->name : 'Nama tidak ditemukan';
                @endphp
                <option selected>{{ $productName }}</option>
                @endforeach
            </div>
            <div style="margin-left: -15px">Tanggal </div>
            <div style="margin-left: 23px; margin-top: -12px;">: {{$formattanggal}}</div>
            <div style="margin-left: -15px">Termin </div>
            <div style="margin-left: 23px; margin-top: -12px;">: {{ $invoice->customer->termin }}</div>
            <!-- <div class="email"><a href="mailto:john@example.com">john@example.com</a></div> -->
        </div>
        <table style="table-layout: auto;">
            <thead>
                <tr>
                    <th style="width: 10px; ">No</th>
                    <th style="width: 370px;">Description</th>
                    <th style="width: 50px;">Kode Booking</th>
                    <th style="width: 20px;">Qty</th>
                    <th style="width: 40px;">Amount</th>
                    <th style="width: 70px;">Total</th>
                </tr>
            </thead>
            <tbody id="itemRows">
                @foreach ($invoiceItems as $i => $item)
                <tr style="font-family: Arial, Helvetica, sans-serif; margin:0;">
                    <td style="text-align: center; border: 1px solid #000;">{{ $i + 1 }}</td>
                    <td style="border: 1px solid #000;">{!! str_replace("\n", '
                        <hr style="margin-left: -11px; margin-right: -11px; border: none; border-top: 1px solid #000;">', e($item->description)) !!}
                    </td>
                    <td style="border: 1px solid #000; font-weight: bold;">{{ $item->kode_booking }}</td>
                    <td style="text-align: center; border: 1px solid #000;">{{ number_format($item->quantity, 0, ',', '.') }}</td>
                    <td style="border: 1px solid #000;">{{ number_format($item->amount, 0, ',', '.') }}</td>
                    <td style="border: 1px solid #000;">{{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: bold; border: 1px solid #000000; font-family: Arial, Helvetica, sans-serif;">Total</td>
                    <td style="font-weight: bold; border: 1px solid #000000; font-family: Arial, Helvetica, sans-serif;">Rp {{ number_format($totalInvoice, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div id="rounded2" style="margin-top: 80px; margin-bottom: 10px; page-break-before: always;">
            <div style="margin-left: 70px; margin-top: -20px;">Payment Detail</div>
            <div style="margin-left: -25px;">Silahkan melakukan pembayaran ke rekening bank berikut : </div>
            <div style="margin-left: -25px; font-weight:bold;">Bank BRI (IDR Account) </div>
            <div style="margin-left: -25px;">Nama Pemilik Rekening : PT KAMAIRA SOLUSI PRATAMA</div>
            <div style="margin-left: -25px; margin-bottom: 10px; font-weight:bold;">Account No : 2020-01-000336-30-0</div>
        </div>
        <div style="margin-left: 500px; margin-top: -110px; font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
            <div>Jakarta, {{$formattanggal}}</div>
            <div style="margin-bottom: 130px;">Thank You for Your Payment</div>
            <div style="margin-left: 30px;">RIZKY FAUZIA</div>
            <div style="margin-left: 45px;">Direktur</div>
        </div>
    </main>
</body>

</html>