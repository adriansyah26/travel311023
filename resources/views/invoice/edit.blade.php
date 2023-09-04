@extends('layout.apps')
@section('content')
<main>
    <div class="container mt-3 px-4">
        <div class="col-lg-12 margin-tb">
            <div>
                <h2>Edit New Invoice</h2>
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

            <form action="{{ route('invoice.update',$invoice->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-4 mt-3 px-4 col-lg-12">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-4 margin-tb px-4">
                                    <div class="form-group">
                                        <strong>Invoice Number</strong>
                                        <input type="text" name="invoice_number" value="{{ $invoice->invoice_number }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4 margin-tb px-4">
                                    <div class="form-group">
                                        <strong>Customers Name</strong>
                                        <select class="form-select" name="customer_id" id="customer_id">
                                            @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ $customer->id == $invoice->customer_id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                            </option>
                                            @endforeach
                                        </select>
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
                                    <button type="button" class="btn btn-success" onclick="saveItemsAndSubmit()">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 mt-3 px-4 col-lg-12 ">
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
                                    @foreach ($invoiceItems as $i => $item)
                                    <tr data-item-id="{{ $item->id }}">
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $item->product_id ? $products->find($item->product_id)->name : 'Nama tidak ditemukan' }}</td>
                                        <td>{{ $item->item }}</td>
                                        <td>{{ $item->kode_booking }}</td>
                                        <td>{!! str_replace("\n", '
                                            <hr style="margin-left: -9px; margin-right: -9px;">', e($item->description)) !!}
                                        </td>
                                        <td>{{ number_format($item->markup, 0, ',', '.') }}</td>
                                        <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                                        <td>{{ number_format($item->amount, 0, ',', '.') }}</td>
                                        <td>{{ number_format($item->service_fee, 0, ',', '.') }}</td>
                                        <td>{{ number_format($item->total, 0, ',', '.') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editInvoiceItemModaledit" onclick="editInvoiceItemModaledit('{{ $item->id }}')"><i class="bi bi-pencil-square"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- The Modal Edit-->
        <div class="modal fade bd-example-modal-lg" id="editInvoiceItemModaledit">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Invoice Item</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="card px-4 col-lg-12 ">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-4 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Products</strong>
                                                <div class="input-group mb-3">
                                                    <select class="form-select" name="product_name" id="product_id" data-products="{{ json_encode($products) }}">
                                                        @foreach ($products as $product)
                                                        <option value="{{ $product->id }}" selected>{{ $product->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Item</strong>
                                                <input type="text" name="item" class="form-control" placeholder="Item" id="item" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Kode Booking</strong>
                                                <input type="text" name="kode_booking" class="form-control" placeholder="Kode Booking" id="kode_booking" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Markup</strong>
                                                <input class="form-control" name="markup" placeholder="Markup" type="text" onkeyup="validateDecimalcreate(this, 0);" id="markup" required></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Quantity</strong>
                                                <input class="form-control" name="quantity" placeholder="Qty" type="text" onkeyup="validateDecimalcreate(this, 0);" id="quantity" required></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Amount</strong>
                                                <input class="form-control" name="amount" placeholder="Amount" type="text" onkeyup="validateDecimalcreate(this, 0);" id="amount" required></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 margin-tb mt-3 px-4">
                                            <div class="form-group">
                                                <strong>Service Fee</strong>
                                                <input class="form-control" name="service_fee" placeholder="Service Fee" type="text" onkeyup="validateDecimalcreate(this, 0);" id="service_fee" required></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 margin-tb mt-3 px-4">
                                            <div class="form-group">
                                                <strong>Total</strong>
                                                <input class="form-control" name="total" placeholder="Total" type="text" readonly onkeyup="validateDecimalcreate(this, 0);" id="total"></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 margin-tb mt-3 px-4">
                                            <div class="form-group">
                                                <strong>Description</strong>
                                                <textarea type="text" name="description" class="form-control" placeholder="Description" required id="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="updateInvoiceItemModal" onclick="saveItemsedit()">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // format penambahan perkalian quantity * (amount + markup) edit
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
    function saveItemsAndSubmit() {
        // Ambil nilai dari elemen-elemen form
        const invoice_number = document.querySelector('input[name="invoice_number"]').value;
        const customer_id = document.querySelector('select[name="customer_id"]').value;
        const statusCheckbox = document.getElementById('status');
        const status = statusCheckbox.checked ? 'True' : 'False';


        // Buat objek FormData dan tambahkan data yang akan dikirim
        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('invoice_number', invoice_number);
        formData.append('customer_id', customer_id);
        formData.append('status', status);
        // Kirim permintaan POST menggunakan Axios
        axios.post("{{ route('invoice.update', $invoice->id) }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if (response.data.success) {
                    // Lakukan pembaruan data jika diperlukan
                    Swal.fire({
                        title: 'Good job!',
                        text: response.data.messages,
                        icon: 'success',
                    });
                } else {
                    // Tangani jika ada kesalahan dari server
                    console.error('Gagal menyimpan item:', response.data.errors || response.data.message);
                }
            })
            .catch(error => {
                // Tangani kesalahan saat koneksi atau server bermasalah
                console.error('Terjadi kesalahan:', error);
            });
    }
</script>

<script>
    // untuk mengambil id ditable
    function editInvoiceItemModaledit(itemId) {
        axios.get(`/invoice/edit-items-edit/${itemId}`)
            .then(response => {
                const item = response.data.item;
                // Populate modal fields with item data
                document.getElementById('product_id').value = item.product_id;
                document.getElementById('item').value = item.item;
                document.getElementById('kode_booking').value = item.kode_booking;
                document.getElementById('description').value = item.description;
                // Menampilkan angka dengan pemisah ribuan (titik) dalam bahasa Indonesia
                const quantityFormatted = item.quantity.toLocaleString('id-ID');
                const amountFormatted = item.amount.toLocaleString('id-ID');
                const markupFormatted = item.markup.toLocaleString('id-ID');
                const service_feeFormatted = item.service_fee.toLocaleString('id-ID');
                const totalFormatted = item.total.toLocaleString('id-ID');
                document.getElementById('quantity').value = quantityFormatted;
                document.getElementById('amount').value = amountFormatted;
                document.getElementById('markup').value = markupFormatted;
                document.getElementById('service_fee').value = service_feeFormatted;
                document.getElementById('total').value = totalFormatted;
                // Show the modal

                // Simpan itemId dalam atribut data-item-id pada tombol "Edit" dalam modal
                const updateInvoiceItemModal = document.getElementById('updateInvoiceItemModal');
                updateInvoiceItemModal.setAttribute('data-item-id', itemId);

                $('#editInvoiceItemModaledit').modal('show');
            })
            .catch(error => {
                console.error(error);
            });
    }
</script>

<script>
    function saveItemsedit() {
        const itemId = document.getElementById('updateInvoiceItemModal').getAttribute('data-item-id'); // Dapatkan ID item yang akan diperbarui

        const productId = document.getElementById('product_id').value;
        const item = document.getElementById('item').value;
        const kode_booking = document.getElementById('kode_booking').value;
        const description = document.getElementById('description').value;
        const quantity = document.getElementById('quantity').value;
        const amount = document.getElementById('amount').value;
        const markup = document.getElementById('markup').value;
        const service_fee = document.getElementById('service_fee').value;
        const total = document.getElementById('total').value;

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('product_id', productId);
        formData.append('item', item);
        formData.append('kode_booking', kode_booking);
        formData.append('description', description);
        formData.append('quantity', quantity);
        formData.append('amount', amount);
        formData.append('markup', markup);
        formData.append('service_fee', service_fee);
        formData.append('total', total);

        axios.post(`/invoice/update-items-update/${itemId}`, formData, {
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

                        $('#editInvoiceItemModaledit').modal('hide');
                    } else {
                        console.error('Item yang diperbarui tidak memiliki ID yang valid.');
                    }
                    // Lakukan pembaruan data dalam tabel jika diperlukan
                    Swal.fire({
                        title: 'Good job!',
                        text: response.data.messages,
                        icon: 'success',
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
        markNewDataAdded();
        resetInputFields();
    }
</script>

<script>
    // Ambil data produk dari tag HTML
    const productsData = JSON.parse(document.getElementById('product_id').getAttribute('data-products'));
    // mengubah table setelah diupdate
    function updateTableRow(updatedItem) {
        const itemRowsContainer = document.getElementById('itemRows');
        const updatedRow = itemRowsContainer.querySelector(`tr[data-item-id="${updatedItem.id}"]`);
        if (updatedRow) {
            const columns = updatedRow.querySelectorAll('td'); // Ambil seluruh kolom dalam baris
            const productName = productsData.find(product => product.id === parseInt(updatedItem.product_id))?.name || 'Products Tidak Tersedia';
            columns[1].textContent = productName;
            columns[2].textContent = updatedItem.item;
            columns[3].textContent = updatedItem.kode_booking;
            columns[4].innerHTML = updatedItem.description.replace(/\n/g, '<hr style="margin-left: -9px; margin-right: -9px;">');
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