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
            <img src="{{ public_path('image/travellogo3.png') }}" alt="image invoice" style="width:150px;height:95px;">
        </div>
    </div>
    <hr style="margin-left: 150px; margin-right: 100px; color:black">
    <main>
        <div id="details" class="clearfix" style="margin-right: 100px;">
            <div id="invoice">
                <div style="margin-top: 30px; margin-right: 60px;">INVOICE</div>
                <div style="margin-left: 100px;">{{ $invoice->invoice_number }}</div>
            </div>
            <div style="border-top: 5px outset#0000FF; margin-right: 480px; margin-top: -20px;"> </div>
            <hr style="margin-right: 480px;">
        </div>
        <div style="border-top: 5px outset#0000FF; margin-right: 100px; margin-left: 500px; margin-top: -33px; "> </div>
        <hr style="margin-right: 100px; margin-left: 500px;">
        <div id="rounded1" style="margin-top: 30px; margin-bottom: 50px;">
            <div style="margin-bottom: 5px; margin-left: 70px; margin-top: -20px;">Customers</div>
            <div style="margin-left: -15px">Nama : {{ $invoice->customer->name }}</div>
            <div style="margin-left: -15px">Note : {{ $invoice->product}}</div>
            <!-- <div class="email"><a href="mailto:john@example.com">john@example.com</a></div> -->
        </div>
        <table>
            <thead>
                <tr>
                    <th class="no" style="width: 5%;">No</th>
                    <th class="product" style="width: 12%;">Product</th>
                    <th class="item" style="width: 40%;">Item</th>
                    <th class="quantity" style="width: 10%;">Quantity</th>
                    <th class="amount" style="width: 16%;">Amount</th>
                    <th class="total" style="width: 17%;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align:center;">{{ $invoice->id }}</td>
                    <td style="text-align:center;">{{ $invoice->product }}</td>
                    <td>{{ $invoice->item }}</td>
                    <td style="text-align:center;">{{ $invoice->quantity }}</td>
                    <td>{{ $invoice->amount }}</td>
                    <td>{{ $invoice->total }}</td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: center;">Total</td>
                    <td>642500</td>
                </tr>
            </tbody>
        </table>
        <div id="rounded2" style="margin-top: 80px; margin-bottom: 10px;">
            <div style="margin-left: 70px; margin-top: -20px">Payment Detail</div>
            <div style="margin-left: -25px;">Silahkan melakukan pembayaran ke rekening bank berikut : </div>
            <div style="margin-left: -25px;">Bank BRI (IDR Account) </div>
            <div style="margin-left: -25px;">Nama Pemilik Rekening : PT KAMAIRA SOLUSI PRATAMA</div>
            <div style="margin-left: -25px; margin-bottom: 10px;">Account No : 2020-01-000336-30-0</div>
        </div>
        <div style="margin-left: 500px; margin-top: -110px; font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
            <div>Jakarta, 24 Juni 2023</div>
            <div style="margin-bottom: 130px;">Thank You for Your Payment</div>
            <div style="margin-left: 30px;">RIZKY FAUZIA</div>
            <div style="margin-left: 45px;">Direktur</div>
        </div>
        <!-- <div id="notices">
            <div>NOTICE:</div>
            <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
        </div> -->
    </main>
    <footer>
        Invoice was created on a computer and is valid without the signature and seal.
    </footer>
    <script src="{{ public_path('js/scripts.js') }}"></script>
</body>

</html>