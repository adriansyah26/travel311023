@extends('layout.apps')
@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="float-start mt-3">
            <h2>Add New Invoice</h2>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form data-action="{{ route('invoice.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card mb-4 mt-3 px-4 col-lg-12 ">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <input type="hidden" name="invoice_id" id="invoice_id">
                            <div class="col-lg-4 margin-tb px-4">
                                <div class="form-group">
                                    <strong>Invoice Number</strong>
                                    <div class="input-group">
                                        <input type="text" name="invoice_number" class="form-control" id="invoice_number" value="{{ $nextInvoiceNumberFull }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 margin-tb px-4">
                                <div class="form-group">
                                    <strong>Customers Name</strong>
                                    <div class="input-group">
                                        <select class="form-select" name="customer_name" id="customer_id">
                                            @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" selected>{{$customer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 margin-tb px-4">
                                <div class="form-group">
                                    <strong>Status</strong>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 margin-tb mt-3 px-4">
                                <button type="button" class="btn btn-success" onclick="saveItemsAndSubmit()">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card mb-4 mt-3 px-4 col-lg-12 ">
            <button type="button" class="btn btn-primary mt-4" style="margin-left: 40px; margin-bottom: -15px; width: 80px" data-bs-toggle="modal" data-bs-target="#invoiceItemModal" disabled><i class="bi bi-file-earmark-plus"></i>Item</button>
            <div class="card-body" style="overflow-x: auto;">
                <div class="container-fluid">
                    <table id="itemTable" class="table table-bordered table-striped mt-3" style="margin-left: 10px; width: 950px; table-layout: fixed;">
                        <thead>
                            <tr style="text-align: center;">
                                <th style="width: 40px;">No</th>
                                <th style="width: 100px;">Products</th>
                                <th style="width: 300px;">Item</th>
                                <th style="width: 130px;">Kode Booking</th>
                                <th style="width: 500px;">Description</th>
                                <th style="width: 100px;">Markup</th>
                                <th style="width: 90px;">Quantity</th>
                                <th style="width: 100px;">Amount</th>
                                <th style="width: 105px;">Service Fee</th>
                                <th style="width: 100px;">Total</th>
                                <th style="width: 70px;">Action</th>
                            </tr>
                        </thead>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <tbody id="itemRows">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal Create-->
    <div class="modal fade bd-example-modal-lg" id="invoiceItemModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Invoice Item</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="card col-lg-12 ">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row mb-3">
                                    <div class="col-lg-4 margin-tb">
                                        <div class="form-group">
                                            <strong>Products</strong>
                                            <div class="input-group">
                                                <select class="form-select" name="product_name" id="product_id" data-products="{{ json_encode($products) }}">
                                                    @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" selected>{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 margin-tb">
                                        <div class="form-group">
                                            <strong>Item</strong>
                                            <div class="input-group">
                                                <input type="text" name="item" class="form-control" placeholder="Item" value="{{ old('item') }}" id="item" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 margin-tb">
                                        <div class="form-group">
                                            <strong>Kode Booking</strong>
                                            <div class="input-group">
                                                <input type="text" name="kode_booking" class="form-control" placeholder="Kode Booking" value="{{ old('kode_booking') }}" id="kode_booking" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 margin-tb">
                                        <div class="form-group">
                                            <strong>Markup</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="markup" placeholder="Markup" type="text" value="{{ old('markup') }}" onkeyup="validateDecimalcreate(this, 0);" id="markup" required></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 margin-tb">
                                        <div class="form-group">
                                            <strong>Quantity</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="quantity" placeholder="Qty" type="text" value="{{ old('quantity') }}" onkeyup="validateDecimalcreate(this, 0);" id="quantity" required></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 margin-tb">
                                        <div class="form-group">
                                            <strong>Amount</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="amount" placeholder="Amount" type="text" value="{{ old('amount') }}" onkeyup="validateDecimalcreate(this, 0);" id="amount" required></input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 margin-tb mt-3">
                                        <div class="form-group">
                                            <strong>Service Fee</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="service_fee" placeholder="Service Fee" type="text" value="{{ old('service_fee') }}" onkeyup="validateDecimalcreate(this, 0);" id="service_fee" required></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 margin-tb mt-3">
                                        <div class="form-group">
                                            <strong>Total</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="total" placeholder="Total" type="text" value="{{ old('total') }}" readonly onkeyup="validateDecimalcreate(this, 0);" id="total"></input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 margin-tb mt-3">
                                        <div class="form-group">
                                            <strong>Description</strong>
                                            <div class="input-group">
                                                <textarea type="text" name="description" class="form-control" placeholder="Description" required id="description">{{ old('description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="saveItems()">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--The Modal Edit -->
    <div class="modal fade bd-example-modal-lg" id="editInvoiceItemModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Invoice Item</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="card col-lg-12 ">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row mb-3">
                                    <div class="col-lg-4 margin-tb">
                                        <div class="form-group">
                                            <strong>Products</strong>
                                            <div class="input-group">
                                                <select class="form-select" name="product_name_edit" id="product_id_edit" data-products-edit="{{ json_encode($products) }}">
                                                    @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" selected>{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 margin-tb">
                                        <div class="form-group">
                                            <strong>Item</strong>
                                            <div class="input-group">
                                                <input type="text" name="itemedit" class="form-control" placeholder="Item" id="itemedit" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 margin-tb">
                                        <div class="form-group">
                                            <strong>Kode Booking</strong>
                                            <div class="input-group">
                                                <input type="text" name="kode_bookingedit" class="form-control" placeholder="Kode Booking" id="kode_bookingedit" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 margin-tb">
                                        <div class="form-group">
                                            <strong>Markup</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="markupedit" placeholder="Markup" type="text" onkeyup="validateDecimaledit(this, 0);" id="markupedit" required></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 margin-tb">
                                        <div class="form-group">
                                            <strong>Quantity</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="quantityedit" placeholder="Qty" type="text" onkeyup="validateDecimaledit(this, 0);" id="quantityedit" required></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 margin-tb">
                                        <div class="form-group">
                                            <strong>Amount</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="amountedit" placeholder="Amount" type="text" onkeyup="validateDecimaledit(this, 0);" id="amountedit" required></input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 margin-tb mt-3">
                                        <div class="form-group">
                                            <strong>Service Fee</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="service_feeedit" placeholder="Service Fee" type="text" onkeyup="validateDecimaledit(this, 0);" id="service_feeedit" required></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 margin-tb mt-3">
                                        <div class="form-group">
                                            <strong>Total</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="totaledit" placeholder="Total" type="text" readonly onkeyup="validateDecimaledit(this, 0);" id="totaledit"></input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 margin-tb mt-3">
                                        <div class="form-group">
                                            <strong>Description</strong>
                                            <div class="input-group">
                                                <textarea type="text" name="descriptionedit" class="form-control" placeholder="Description" required id="descriptionedit"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="updateInvoiceItemModal" onclick="updateInvoiceItemModal()">Save</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
</main>

<script>
    // format penambahan perkalian quantity * (amount + markup) create
    function addCommas(nStr) {
        nStr += "";
        x = nStr.split(".");
        x1 = x[0];
        x2 = x.length > 1 ? "." + x[1] : "";
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, "$1" + "." + "$2");
        }
        return x1 + x2;
    }
</script>

<script>
    const paramModal = {
        quantity: 0,
        amount: 0,
        markup: 0,
        total: 0,
        service_fee: 0,
    }

    let isNewDataAdded = false; // Tandai apakah data baru sudah ditambahkan

    // Fungsi untuk memastikan nilai desimal minimal 0
    function validateDecimalcreate(input, min) {
        let validNumber = parseFloat(`${input.value}`.replace(/[^0-9]/g, ''));
        let typeInputName = input.getAttribute('name');

        if (typeof paramModal[typeInputName] !== 'undefined') {
            paramModal[typeInputName] = isNaN(validNumber) ? 0 : validNumber;
            paramModal.total = paramModal.quantity * paramModal.amount;

            for (let k in paramModal) {
                document.getElementsByName(k)[0].value = addCommas(paramModal[k]);
            }
        }
    }

    function markNewDataAdded() {
        isNewDataAdded = true;
    }

    function resetInputFields() {
        if (isNewDataAdded) {
            for (let k in paramModal) {
                paramModal[k] = 0;
                document.getElementsByName(k)[0].value = addCommas(paramModal[k]);
            }
            isNewDataAdded = false; // Reset flag
        }
    }
</script>

<script>
    // format penambahan perkalian quantity * (amount + markup) edit
    function addCommasedit(nStr) {
        nStr += "";
        x = nStr.split(".");
        x1 = x[0];
        x2 = x.length > 1 ? "." + x[1] : "";
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, "$1" + "." + "$2");
        }
        return x1 + x2;
    }
</script>

<script>
    const paramModaledit = {
        quantityedit: 0,
        amountedit: 0,
        markupedit: 0,
        totaledit: 0,
        service_feeedit: 0,
    }

    let isNewDataAddededit = false; // Tandai apakah data baru sudah ditambahkan

    // Fungsi untuk memastikan nilai desimal minimal 0
    function validateDecimaledit(input, min) {
        let validNumberedit = parseFloat(`${input.value}`.replace(/[^0-9]/g, ''));
        let typeInputNameedit = input.getAttribute('name');

        if (typeof paramModaledit[typeInputNameedit] !== 'undefined') {
            paramModaledit[typeInputNameedit] = isNaN(validNumberedit) ? 0 : validNumberedit;
            paramModaledit.totaledit = paramModaledit.quantityedit * paramModaledit.amountedit;

            for (let k in paramModaledit) {
                document.getElementsByName(k)[0].value = addCommasedit(paramModaledit[k]);
            }
        }
    }

    function markNewDataAddededit() {
        isNewDataAddededit = true;
    }

    function resetInputFieldsedit() {
        if (isNewDataAddededit) {
            for (let k in paramModaledit) {
                paramModaledit[k] = 0;
                document.getElementsByName(k)[0].value = addCommasedit(paramModaledit[k]);
            }
            isNewDataAddededit = false; // Reset flag
        }
    }
</script>

<!-- <script>
    // Fungsi untuk menghapus tanda titik dan tanda koma dari string angka
    function removeSeparators(input) {
        return input.replace(/[.,]/g, '');
    }

    // // Fungsi untuk memformat angka dengan pemisah ribuan
    // function formatNumber(number) {
    //     return new Intl.NumberFormat('id-ID').format(number);
    // }

    // // Penambahan otomatis quantity * (amount + markup) dengan format ribuan
    // function create() {
    //     var txtFirstNumberValue = document.getElementById('quantity').value;
    //     var txtSecondNumberValue = document.getElementById('amount').value;
    //     var txtThirdNumberValue = document.getElementById('markup').value;

    //     var quantity = parseFloat(removeSeparators(txtFirstNumberValue));
    //     var amount = parseFloat(removeSeparators(txtSecondNumberValue));
    //     var markup = parseFloat(removeSeparators(txtThirdNumberValue));

    //     var total = quantity * (amount + markup);

    //     if (!isNaN(total)) {

    //         var formattedTotal = formatNumber(total);
    //         var formattedQuantity = formatNumber(quantity);
    //         var formattedAmount = formatNumber(amount);
    //         var formattedMarkup = formatNumber(markup);
    //         console.log(total, formattedTotal, formattedQuantity, formattedAmount, formattedMarkup)

    //         document.getElementById('total').value = formattedTotal;
    //         document.getElementById('quantity').value = formattedQuantity;
    //         document.getElementById('amount').value = formattedAmount;
    //         document.getElementById('markup').value = formattedMarkup;
    //     }
    // }

    // // Memanggil fungsi create() saat halaman dimuat
    // create();
</script>

<script>
    // Fungsi untuk memastikan nilai desimal minimal 0
    function validateDecimaledit(input, min) {
        var value = parseFloat(input.value);
        if (isNaN(value) || value < min) {
            input.value = min;
        }
        edit(); // Panggil fungsi edit() untuk menghitung total
    }

    // Fungsi untuk menghapus tanda titik dan tanda koma dari string angka
    function removeSeparators(input) {
        return input.replace(/[.,]/g, '');
    }

    // Fungsi untuk memformat angka dengan pemisah ribuan
    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Penambahan otomatis quantity * (amount + markup) dengan format ribuan
    function edit() {
        var txtFirstNumberValue = document.getElementById('quantityedit').value;
        var txtSecondNumberValue = document.getElementById('amountedit').value;
        var txtThirdNumberValue = document.getElementById('markupedit').value;

        var quantity = parseFloat(removeSeparators(txtFirstNumberValue));
        var amount = parseFloat(removeSeparators(txtSecondNumberValue));
        var markup = parseFloat(removeSeparators(txtThirdNumberValue));

        var total = quantity * (amount + markup);

        if (!isNaN(total)) {
            var formattedTotal = formatNumber(total);
            var formattedQuantity = formatNumber(quantity);
            var formattedAmount = formatNumber(amount);
            var formattedMarkup = formatNumber(markup);

            document.getElementById('totaledit').value = formattedTotal;
            document.getElementById('quantityedit').value = formattedQuantity;
            document.getElementById('amountedit').value = formattedAmount;
            document.getElementById('markupedit').value = formattedMarkup;
        }
    }

    // Memanggil fungsi create() saat halaman dimuat
    edit();
</script> -->

<script>
    // Ambil data produk dari tag HTML
    const productsData = JSON.parse(document.getElementById('product_id').getAttribute('data-products'));
    // Fungsi untuk menyimpan item
    function saveItems() {
        // Kumpulkan data item dari form
        const invoiceId = document.getElementById('invoice_id').value;
        const productId = document.getElementById('product_id').value;
        const item = document.getElementById('item').value;
        const kode_booking = document.getElementById('kode_booking').value;
        const description = document.getElementById('description').value;
        const quantity = document.getElementById('quantity').value;
        const amount = document.getElementById('amount').value;
        const markup = document.getElementById('markup').value;
        const service_fee = document.getElementById('service_fee').value;
        const total = document.getElementById('total').value;

        // Buat FormData untuk mengirim data ke server
        const formData = new FormData();
        formData.append('invoice_id', invoiceId); // Simpan sebagai nilai tunggal
        formData.append('product_id', productId);
        formData.append('item', item);
        formData.append('kode_booking', kode_booking);
        formData.append('description', description);
        formData.append('quantity', quantity);
        formData.append('amount', amount);
        formData.append('markup', markup);
        formData.append('service_fee', service_fee);
        formData.append('total', total);

        // Deklarasi variabel untuk nomor urutan
        let rowCount = 1;

        // Kirim permintaan POST untuk menyimpan item
        axios.post("{{ route('invoice.saveItem') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if (response.data.success) {
                    // Item berhasil disimpan, tampilkan di tabel
                    const items = response.data.items;
                    const itemRowsContainer = document.getElementById('itemRows');
                    itemRowsContainer.innerHTML = ''; // Kosongkan tabel sebelum mengisi ulang
                    items.forEach(item => {
                        // merubah product_id menjadi product name
                        const productName = productsData.find(product => product.id === parseInt(item.product_id))?.name || 'Products Tidak Tersedia';
                        // Menampilkan angka dengan pemisah ribuan (titik) dalam bahasa Indonesia
                        const markupFormatted = item.markup.toLocaleString('id-ID');
                        const quantityFormatted = item.quantity.toLocaleString('id-ID');
                        const amountFormatted = item.amount.toLocaleString('id-ID');
                        const service_feeFormatted = item.service_fee.toLocaleString('id-ID');
                        const totalFormatted = item.total.toLocaleString('id-ID');
                        const itemRow = `<tr data-item-id="${item.id}">
                                <td>${rowCount++}</td>
                                <td>${productName}</td>
                                <td>${item.item}</td>
                                <td>${item.kode_booking}</td>
                                <td>${item.description.replace(/\n/g, '<hr style="margin-left: -9px; margin-right: -9px;">')}</td>
                                <td>${markupFormatted}</td>
                                <td>${quantityFormatted}</td>
                                <td>${amountFormatted}</td>
                                <td>${service_feeFormatted}</td>
                                <td>${totalFormatted}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editInvoiceItemModal" onclick="editInvoiceItemModal('${item.id}')"><i class="bi bi-pencil-square"></i></button>
                                </td>
                            </tr>`;
                        itemRowsContainer.insertAdjacentHTML('beforeend', itemRow);

                        // Tambahkan 1 ke nomor urutan
                        // rowCount++;

                        $('#invoiceItemModal').modal('hide');

                        document.getElementById("product_id").value = "";
                        document.getElementById("item").value = "";
                        document.getElementById("kode_booking").value = "";
                        document.getElementById("description").value = "";
                        document.getElementById("quantity").value = "";
                        document.getElementById("amount").value = "";
                        document.getElementById("markup").value = "";
                        document.getElementById("service_fee").value = "";
                        document.getElementById("total").value = "";

                        Swal.fire({
                            title: 'Success',
                            text: response.data.messages,
                            icon: 'success'
                        });
                    });
                } else {
                    // Handle jika ada kesalahan
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed created invoice item!',
                    })
                    console.error('Gagal menyimpan item:', response.data.message);
                }
            })
            .catch(error => {
                // Handle jika ada kesalahan koneksi atau server
                console.error('Terjadi kesalahan:', error);
            });
        markNewDataAdded(); // Tandai bahwa data baru ditambahkan
        resetInputFields(); // Reset input fields
    }
</script>

<script>
    function saveItemsAndSubmit() {
        const invoice_number = document.getElementById('invoice_number').value;
        const customer_id = document.getElementById('customer_id').value;
        const statusCheckbox = document.getElementById('status');
        const status = statusCheckbox.checked ? 'True' : 'False';

        const formData = new FormData();
        formData.append('invoice_number', invoice_number); // Simpan sebagai nilai tunggal
        formData.append('customer_id', customer_id);
        formData.append('status', status);

        axios.post("{{ route('invoice.store') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if (response.data.success) {
                    // Item berhasil disimpan, tampilkan di tabel
                    document.getElementById("invoice_id").value = response.data.items.id;
                    $('button[data-bs-target="#invoiceItemModal"]').removeAttr('disabled')
                    Swal.fire({
                        title: 'Success',
                        text: response.data.messages,
                        icon: 'success'
                    });
                } else {
                    // Handle jika ada kesalahan
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed created invoice!',
                    })
                    console.error('Gagal menyimpan item:', response.data.errors || response.data.message);
                }
            })
            .catch(error => {
                // Handle jika ada kesalahan koneksi atau server
                console.error('Terjadi kesalahan:', error);
            });
    }
</script>

<script>
    function editInvoiceItemModal(itemId) {
        axios.get(`/invoice/edit-items/${itemId}`)
            .then(response => {
                if (response.data.success) {
                    const item = response.data.item;
                    document.getElementById('product_id_edit').value = item.product_id;
                    document.getElementById('itemedit').value = item.item;
                    document.getElementById('kode_bookingedit').value = item.kode_booking;
                    document.getElementById('descriptionedit').value = item.description;
                    // Menampilkan angka dengan pemisah ribuan (titik) dalam bahasa Indonesia
                    const quantityFormatted = item.quantity.toLocaleString('id-ID');
                    const amountFormatted = item.amount.toLocaleString('id-ID');
                    const markupFormatted = item.markup.toLocaleString('id-ID');
                    const service_feeFormatted = item.service_fee.toLocaleString('id-ID');
                    const totalFormatted = item.total.toLocaleString('id-ID');
                    document.getElementById('quantityedit').value = quantityFormatted;
                    document.getElementById('amountedit').value = amountFormatted;
                    document.getElementById('markupedit').value = markupFormatted;
                    document.getElementById('service_feeedit').value = service_feeFormatted;
                    document.getElementById('totaledit').value = totalFormatted;
                    // ... Set other values if needed ...
                    // Simpan itemId dalam atribut data-item-id pada tombol "Edit" dalam modal
                    const updateInvoiceItemModal = document.getElementById('updateInvoiceItemModal');
                    updateInvoiceItemModal.setAttribute('data-item-id', itemId);

                    $('#editInvoiceItemModal').modal('show');
                } else {
                    console.error('Gagal mengambil data item untuk edit');
                }
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
            });
    }
</script>

<script>
    function updateInvoiceItemModal() {
        const itemId = document.getElementById('updateInvoiceItemModal').getAttribute('data-item-id'); // Dapatkan ID item yang akan diperbarui

        const product = document.getElementById('product_id_edit').value;
        const item = document.getElementById('itemedit').value;
        const kode_booking = document.getElementById('kode_bookingedit').value;
        const description = document.getElementById('descriptionedit').value;
        const quantity = document.getElementById('quantityedit').value;
        const amount = document.getElementById('amountedit').value;
        const markup = document.getElementById('markupedit').value;
        const service_fee = document.getElementById('service_feeedit').value;
        const total = document.getElementById('totaledit').value;

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('product_id_edit', product);
        formData.append('itemedit', item);
        formData.append('kode_bookingedit', kode_booking);
        formData.append('descriptionedit', description);
        formData.append('quantityedit', quantity);
        formData.append('amountedit', amount);
        formData.append('markupedit', markup);
        formData.append('service_feeedit', service_fee);
        formData.append('totaledit', total);

        axios.post(`/invoice/update-items/${itemId}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if (response.data.success) {
                    // Semua pembaruan berhasil, perbarui tabel dengan versi terbaru
                    const updatedItem = response.data.item;
                    if (updatedItem && updatedItem.id) {
                        // Panggil fungsi updateTableRow untuk memperbarui tampilan tabel
                        updateTableRow(updatedItem);


                        $('#editInvoiceItemModal').modal('hide');
                    } else {
                        console.error('Item yang diperbarui tidak memiliki ID yang valid.');
                    }
                    // Lakukan pembaruan data dalam tabel jika diperlukan
                    Swal.fire({
                        title: 'Success',
                        text: response.data.messages,
                        icon: 'success'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed updated invoice item!',
                    })
                    console.error('Gagal memperbarui item:', response.data.message);
                }
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
            });
        markNewDataAddededit();
        resetInputFieldsedit();
    }
</script>

<script>
    // Ambil data produk dari tag HTML
    const productsDataedit = JSON.parse(document.getElementById('product_id_edit').getAttribute('data-products-edit'));
    // mengubah table setelah diupdate
    function updateTableRow(updatedItem) {
        const itemRowsContainer = document.getElementById('itemRows');
        const updatedRow = itemRowsContainer.querySelector(`tr[data-item-id="${updatedItem.id}"]`);
        if (updatedRow) {
            const columns = updatedRow.querySelectorAll('td'); // Ambil seluruh kolom dalam baris
            const productName = productsDataedit.find(product => product.id === parseInt(updatedItem.product_id))?.name || 'Products Tidak Tersedia';
            columns[1].textContent = productName
            columns[2].textContent = updatedItem.item;
            columns[3].textContent = updatedItem.kode_booking;
            columns[4].innerHTML = updatedItem.description.replace(/\n/g, '<hr style="margin-left: -9px; margin-right: -9px; border: none; border-top: 1px solid #000;">');
            columns[5].textContent = updatedItem.markup.toLocaleString('id-ID');
            columns[6].textContent = updatedItem.quantity.toLocaleString('id-ID');
            columns[7].textContent = updatedItem.amount.toLocaleString('id-ID');
            columns[8].textContent = updatedItem.service_fee.toLocaleString('id-ID');
            columns[9].textContent = updatedItem.total.toLocaleString('id-ID');
        } else {
            console.error('Baris yang akan diperbarui tidak ditemukan.');
        }
    }
</script>

@endsection