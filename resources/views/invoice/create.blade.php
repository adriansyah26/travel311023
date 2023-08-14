@extends('layout.apps')
@section('content')
<main>
    <div class="container mt-3 px-4">
        <div class="col-lg-12 margin-tb">
            <div>
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

            <form data-action="{{ route('invoice.store') }}" method="POST" enctype="multipart/form-data" id="createinvoice">
                @csrf

                <div class="card mb-4 mt-3 px-4 col-lg-12 ">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <input type="hidden" name="invoice_id" id="invoice_id">
                                <div class="col-lg-4 margin-tb px-4">
                                    <div class="form-group">
                                        <strong>Invoice Number</strong>
                                        <input type="text" name="invoice_number" class="form-control" id="invoice_number" value="{{ $nextInvoiceNumberFull }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4 margin-tb px-4">
                                    <div class="form-group">
                                        <strong>Customers Name</strong>
                                        <select class="form-select" name="customer_id" id="customer_id">
                                            @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" selected>{{$customer->name}}</option>
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
                                    <button type="button" class="btn btn-success" onclick="saveItemsAndSubmit()">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 mt-3 px-4 col-lg-12 ">
                    <div class="card-body" style="overflow-x: auto;">
                        <button type="button" class="btn btn-primary" style="margin-left: 21px;" data-bs-toggle="modal" data-bs-target="#invoiceItemModal"><i class="bi bi-file-earmark-plus"></i>Item</button>
                        <div class="container-fluid">
                            <table id="itemTable" class="table table-bordered table-striped mt-3" style="margin-left: 10px; width: 950px; table-layout: fixed;">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;">No</th>
                                        <th style="width: 100px;">Products</th>
                                        <th style="width: 300px;">Item</th>
                                        <th style="width: 500px;">Description</th>
                                        <th style="width: 90px;">Quantity</th>
                                        <th style="width: 100px;">Amount</th>
                                        <th style="width: 100px;">Markup</th>
                                        <th style="width: 100px;">Total</th>
                                        <th style="width: 70px;">Action</th>
                                    </tr>
                                </thead>
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <tbody id="itemRows">
                                    <!-- <input type="hidden" name="items" id="itemData" /> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
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
                        <div class="card px-4 col-lg-12 ">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Products</strong>
                                                <div class="input-group mb-3">
                                                    <select class="form-select" name="product" id="product">
                                                        @foreach ($products as $product)
                                                        <option value="{{ $product->name }}" selected>{{ $product->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Item</strong>
                                                <input type="text" name="item" class="form-control" placeholder="Item" value="{{ old('item') }}" id="item" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Quantity</strong>
                                                <input class="form-control" name="quantity" placeholder="Quantity" type="number" value="{{ old('quantity') }}" onkeyup="create();" id="quantity" required></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Amount</strong>
                                                <input class="form-control" name="amount" placeholder="Amount" type="number" value="{{ old('amount') }}" onkeyup="create();" id="amount" required></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 margin-tb mt-3 px-4">
                                            <div class="form-group">
                                                <strong>Markup</strong>
                                                <input class="form-control" name="markup" placeholder="Markup" type="number" value="{{ old('markup') }}" onkeyup="create();" id="markup" required></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 margin-tb mt-3 px-4">
                                            <div class="form-group">
                                                <strong>Total</strong>
                                                <input class="form-control" name="total" placeholder="Total" type="number" value="{{ old('total') }}" readonly onkeyup="create();" id="total"></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 margin-tb mt-3 px-4">
                                            <div class="form-group">
                                                <strong>Description</strong>
                                                <textarea type="text" name="description" class="form-control" placeholder="Description" required id="description">{{ old('description') }}</textarea>
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
                        <div class="card px-4 col-lg-12 ">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Products</strong>
                                                <div class="input-group mb-3">
                                                    <select class="form-select" name="productedit" id="productedit">
                                                        @foreach ($products as $product)
                                                        <option value="{{ $product->name }}" selected>{{ $product->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Item</strong>
                                                <input type="text" name="itemedit" class="form-control" placeholder="Item" id="itemedit" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Quantity</strong>
                                                <input class="form-control" name="quantityedit" placeholder="Quantity" type="number" onkeyup="edit();" id="quantityedit" required></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 margin-tb px-4">
                                            <div class="form-group">
                                                <strong>Amount</strong>
                                                <input class="form-control" name="amountedit" placeholder="Amount" type="number" onkeyup="edit();" id="amountedit" required></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 margin-tb mt-3 px-4">
                                            <div class="form-group">
                                                <strong>Markup</strong>
                                                <input class="form-control" name="markupedit" placeholder="Markup" type="number" onkeyup="edit();" id="markupedit" required></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 margin-tb mt-3 px-4">
                                            <div class="form-group">
                                                <strong>Total</strong>
                                                <input class="form-control" name="totaledit" placeholder="Total" type="number" readonly onkeyup="edit();" id="totaledit"></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 margin-tb mt-3 px-4">
                                            <div class="form-group">
                                                <strong>Description</strong>
                                                <textarea type="text" name="descriptionedit" class="form-control" placeholder="Description" required id="descriptionedit"></textarea>
                                            </div>
                                        </div>
                                    </div>
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
    </div>
</main>
<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var switchCheckbox = document.getElementById('status');
        var switchInput = document.querySelector('input[name="status"]');

        switchCheckbox.addEventListener('change', function() {
            if (switchCheckbox.checked) {
                switchInput.value = 'True';
            } else {
                switchInput.value = 'False';
            }
        });
    });
</script> -->

<script>
    // penambahan otomatis quantity * (amount + markup)
    function create() {
        var txtFirstNumberValue = document.getElementById('quantity').value;
        var txtSecondNumberValue = document.getElementById('amount').value;
        var txtThirdNumberValue = document.getElementById('markup').value;
        var result = parseInt(txtFirstNumberValue) * (parseInt(txtSecondNumberValue) + parseInt(txtThirdNumberValue));
        if (!isNaN(result)) {
            document.getElementById('total').value = result;
        }
    }
</script>

<script>
    // penambahan otomatis quantity * (amount + markup)
    function edit() {
        var txtFirstNumberValue = document.getElementById('quantityedit').value;
        var txtSecondNumberValue = document.getElementById('amountedit').value;
        var txtThirdNumberValue = document.getElementById('markupedit').value;
        var result = parseInt(txtFirstNumberValue) * (parseInt(txtSecondNumberValue) + parseInt(txtThirdNumberValue));
        if (!isNaN(result)) {
            document.getElementById('totaledit').value = result;
        }
    }
</script>

<script>
    // Fungsi untuk menyimpan item
    function saveItems() {
        // Kumpulkan data item dari form
        const invoiceId = document.getElementById('invoice_id').value;
        const product = document.getElementById('product').value;
        const item = document.getElementById('item').value;
        const description = document.getElementById('description').value;
        const quantity = document.getElementById('quantity').value;
        const amount = document.getElementById('amount').value;
        const markup = document.getElementById('markup').value;
        const total = document.getElementById('total').value;

        // Buat FormData untuk mengirim data ke server
        const formData = new FormData();
        formData.append('invoice_id', invoiceId); // Simpan sebagai nilai tunggal
        formData.append('product', product);
        formData.append('item', item);
        formData.append('description', description);
        formData.append('quantity', quantity);
        formData.append('amount', amount);
        formData.append('markup', markup);
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
                        const itemRow = `<tr data-item-id="${item.id}">
                                <td>${rowCount++}</td>
                                <td>${item.product}</td>
                                <td>${item.item}</td>
                                <td>${item.description}</td>
                                <td>${item.quantity}</td>
                                <td>${item.amount}</td>
                                <td>${item.markup}</td>
                                <td>${item.total}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editInvoiceItemModal" onclick="editInvoiceItemModal('${item.id}')">Edit</button>
                                </td>
                            </tr>`;
                        itemRowsContainer.insertAdjacentHTML('beforeend', itemRow);

                        // Tambahkan 1 ke nomor urutan
                        // rowCount++;

                        $('#invoiceItemModal').modal('hide');

                        document.getElementById("product").value = "";
                        document.getElementById("item").value = "";
                        document.getElementById("description").value = "";
                        document.getElementById("quantity").value = "";
                        document.getElementById("amount").value = "";
                        document.getElementById("markup").value = "";
                        document.getElementById("total").value = "";
                    });
                } else {
                    // Handle jika ada kesalahan
                    console.error('Gagal menyimpan item:', response.data.message);
                }
            })
            .catch(error => {
                // Handle jika ada kesalahan koneksi atau server
                console.error('Terjadi kesalahan:', error);
            });
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
                    alert(response.data.messages)
                } else {
                    // Handle jika ada kesalahan
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
                    document.getElementById('productedit').value = item.product;
                    document.getElementById('itemedit').value = item.item;
                    document.getElementById('descriptionedit').value = item.description;
                    document.getElementById('quantityedit').value = item.quantity;
                    document.getElementById('amountedit').value = item.amount;
                    document.getElementById('markupedit').value = item.markup;
                    document.getElementById('totaledit').value = item.total;

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

        const product = document.getElementById('productedit').value;
        const item = document.getElementById('itemedit').value;
        const description = document.getElementById('descriptionedit').value;
        const quantity = document.getElementById('quantityedit').value;
        const amount = document.getElementById('amountedit').value;
        const markup = document.getElementById('markupedit').value;
        const total = document.getElementById('totaledit').value;

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('productedit', product);
        formData.append('itemedit', item);
        formData.append('descriptionedit', description);
        formData.append('quantityedit', quantity);
        formData.append('amountedit', amount);
        formData.append('markupedit', markup);
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
                } else {
                    console.error('Gagal memperbarui item:', response.data.message);
                }
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
            });
    }
</script>

<script>
    // mengubah table setelah diupdate
    function updateTableRow(updatedItem) {
        const itemRowsContainer = document.getElementById('itemRows');
        const updatedRow = itemRowsContainer.querySelector(`tr[data-item-id="${updatedItem.id}"]`);
        if (updatedRow) {
            const columns = updatedRow.querySelectorAll('td'); // Ambil seluruh kolom dalam baris
            columns[1].textContent = updatedItem.product;
            columns[2].textContent = updatedItem.item;
            columns[3].textContent = updatedItem.description;
            columns[4].textContent = updatedItem.quantity;
            columns[5].textContent = updatedItem.amount;
            columns[6].textContent = updatedItem.markup;
            columns[7].textContent = updatedItem.total;
        } else {
            console.error('Baris yang akan diperbarui tidak ditemukan.');
        }
    }
</script>




<!-- <script>
    function saveItems() {
        var items = [];

        // Loop through table rows and gather item data
        var rows = document.querySelectorAll('#itemTable tbody tr');
        rows.forEach(function(row) {
            var product = row.querySelector('.product').value;
            var item = row.querySelector('.item').value;
            var description = row.querySelector('.description').value;
            var quantity = row.querySelector('.quantity').value;
            var amount = row.querySelector('.amount').value;
            var markup = row.querySelector('.markup').value;
            var total = row.querySelector('.total').value;

            items.push({
                product: product,
                item: item,
                description: description,
                quantity: quantity,
                amount: amount,
                markup: markup,
                total: total
            });
        });

        // Set the JSON data to the hidden input
        document.getElementById('itemData').value = JSON.stringify(items);
    }
</script> -->


<!-- <script>
    // Mengatur penyimpanan item menggunakan Axios
    var saveButton = document.getElementById('saveButton');
    saveButton.addEventListener('click', saveItems);

    function saveItems() {
        // Mengumpulkan data dari input pada halaman
        var product = document.getElementsByName('product[]');
        var item = document.getElementsByName('item[]');
        var description = document.getElementsByName('description[]');
        var quantity = document.getElementsByName('quantity[]');
        var amount = document.getElementsByName('amount[]');
        var markup = document.getElementsByName('markup[]');
        var total = document.getElementsByName('total[]');
        var _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Menggabungkan data ke dalam objek requestData
        var requestData = {
            _token: _token,
            product: [],
            item: [],
            description: [],
            quantity: [],
            amount: [],
            markup: [],
            total: []
        };

        for (var i = 0; i < product.length; i++) {
            requestData.product.push(product[i].value);
            requestData.item.push(item[i].value);
            requestData.description.push(description[i].value);
            requestData.quantity.push(quantity[i].value);
            requestData.amount.push(amount[i].value);
            requestData.markup.push(markup[i].value);
            requestData.total.push(total[i].value);
        }

        // Mengirim data ke server menggunakan Axios
        axios.post('/invoice/saveItem', requestData)
            .then(function(response) {
                // Tampilkan pesan sukses atau lakukan aksi lain
                console.log(response.data.message);

                // Add the new row to the table here
                for (var i = 0; i < product.length; i++) {
                    var newRow = document.createElement('tr');
                    newRow.innerHTML = `
                    <td>${product[i].value}</td>
                    <td>${item[i].value}</td>
                    <td>${description[i].value}</td>
                    <td>${quantity[i].value}</td>
                    <td>${amount[i].value}</td>
                    <td>${markup[i].value}</td>
                    <td>${total[i].value}</td>
                `;
                    document.getElementById('itemRows').appendChild(newRow);
                }
            })
            .catch(function(error) {
                // Tangani kesalahan jika terjadi
                console.error(error);
            });
    }
</script> -->







<!-- <script>
    // Fungsi untuk menambahkan baris baru pada tabel
    function addRow() {
        var product = document.getElementById("product").value;
        var item = document.getElementById("item").value;
        var description = document.getElementById("description").value;
        var quantity = document.getElementById("quantity").value;
        var amount = document.getElementById("amount").value;
        var markup = document.getElementById("markup").value;
        var total = document.getElementById("total").value;
        // var invoiceId = document.getElementById("invoice_id").value; // Ambil nilai invoice_id dari input tersembunyi

        var table = document.getElementById("itemTable");
        var row = table.insertRow(-1);

        var cellNo = row.insertCell(0);
        var cellProduct = row.insertCell(1);
        var cellItem = row.insertCell(2);
        var cellDescription = row.insertCell(3);
        var cellQuantity = row.insertCell(4);
        var cellAmount = row.insertCell(5);
        var cellMarkup = row.insertCell(6);
        var cellTotal = row.insertCell(7);

        cellNo.innerHTML = table.rows.length - 1;
        cellProduct.innerHTML = product;
        cellItem.innerHTML = item;
        cellDescription.innerHTML = description;
        cellQuantity.innerHTML = quantity;
        cellAmount.innerHTML = amount;
        cellMarkup.innerHTML = markup;
        cellTotal.innerHTML = total;

        // Tambahkan input tersembunyi untuk menyimpan data item pada form
        var itemDataInput = document.createElement('input');
        itemDataInput.setAttribute('type', 'hidden');
        itemDataInput.setAttribute('name', 'product[]');
        itemDataInput.setAttribute('value', product);
        row.appendChild(itemDataInput);

        itemDataInput = document.createElement('input');
        itemDataInput.setAttribute('type', 'hidden');
        itemDataInput.setAttribute('name', 'item[]');
        itemDataInput.setAttribute('value', item);
        row.appendChild(itemDataInput);

        itemDataInput = document.createElement('input');
        itemDataInput.setAttribute('type', 'hidden');
        itemDataInput.setAttribute('name', 'description[]');
        itemDataInput.setAttribute('value', description);
        row.appendChild(itemDataInput);

        itemDataInput = document.createElement('input');
        itemDataInput.setAttribute('type', 'hidden');
        itemDataInput.setAttribute('name', 'quantity[]');
        itemDataInput.setAttribute('value', quantity);
        row.appendChild(itemDataInput);

        itemDataInput = document.createElement('input');
        itemDataInput.setAttribute('type', 'hidden');
        itemDataInput.setAttribute('name', 'amount[]');
        itemDataInput.setAttribute('value', amount);
        row.appendChild(itemDataInput);

        itemDataInput = document.createElement('input');
        itemDataInput.setAttribute('type', 'hidden');
        itemDataInput.setAttribute('name', 'markup[]');
        itemDataInput.setAttribute('value', markup);
        row.appendChild(itemDataInput);

        itemDataInput = document.createElement('input');
        itemDataInput.setAttribute('type', 'hidden');
        itemDataInput.setAttribute('name', 'total[]');
        itemDataInput.setAttribute('value', total);
        row.appendChild(itemDataInput);

        // itemDataInput = document.createElement('input');
        // itemDataInput.setAttribute('type', 'hidden');
        // itemDataInput.setAttribute('name', 'invoice_id[]');
        // itemDataInput.setAttribute('value', invoiceId);
        // row.appendChild(itemDataInput);

        // Bersihkan input fields
        document.getElementById("item").value = "";
        document.getElementById("description").value = "";
        document.getElementById("quantity").value = "";
        document.getElementById("amount").value = "";
        document.getElementById("markup").value = "";
        document.getElementById("total").value = "";
    }

    // Fungsi untuk mengirimkan form ketika tombol Submit diklik
    function submitInvoice() {
        document.getElementById("createinvoice").submit();
    }
</script> -->


<!-- <script>
    function addRow() {
        // ...
        var table = document.getElementById("itemTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        var cols = [];
        for (var i = 0; i < 8; i++) {
            cols[i] = newRow.insertCell(i);
        }

        // Tambahkan input element sesuai dengan kolom tabel item
        cols[1].innerHTML = '<input type="text" name="items[' + table.rows.length + '][product]" class="form-control" placeholder="Product">';
        cols[2].innerHTML = '<input type="text" name="items[' + table.rows.length + '][item]" class="form-control" placeholder="Item">';
        cols[3].innerHTML = '<input type="text" name="items[' + table.rows.length + '][description]" class="form-control" placeholder="Description">';
        cols[4].innerHTML = '<input type="number" name="items[' + table.rows.length + '][quantity]" class="form-control" placeholder="Quantity" onkeyup="calculateTotal(' + table.rows.length + ')">';
        cols[5].innerHTML = '<input type="number" name="items[' + table.rows.length + '][amount]" class="form-control" placeholder="Amount" onkeyup="calculateTotal(' + table.rows.length + ')">';
        cols[6].innerHTML = '<input type="number" name="items[' + table.rows.length + '][markup]" class="form-control" placeholder="Markup" onkeyup="calculateTotal(' + table.rows.length + ')">';
        cols[7].innerHTML = '<input type="number" name="items[' + table.rows.length + '][total]" class="form-control" placeholder="Total" readonly>';

        // Simpan data item dalam hidden input dengan name "items"
        saveItemData();
    }

    function calculateTotal(rowNum) {
        var quantityInput = document.getElementsByName('items[' + rowNum + '][quantity]')[0];
        var amountInput = document.getElementsByName('items[' + rowNum + '][amount]')[0];
        var markupInput = document.getElementsByName('items[' + rowNum + '][markup]')[0];
        var totalInput = document.getElementsByName('items[' + rowNum + '][total]')[0];

        var quantity = parseInt(quantityInput.value);
        var amount = parseInt(amountInput.value);
        var markup = parseInt(markupInput.value);

        if (!isNaN(quantity) && !isNaN(amount) && !isNaN(markup)) {
            var total = quantity * (amount + markup);
            totalInput.value = total;
        } else {
            totalInput.value = '';
        }
    }

    // Fungsi untuk menyimpan data item ke input hidden sebelum submit form
    function saveItem() {
        var items = [];
        var table = document.getElementById("itemTable").getElementsByTagName('tbody')[0];
        var rows = table.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {
            var item = {
                product: rows[i].cells[1].getElementsByTagName('input')[0].value,
                item: rows[i].cells[2].getElementsByTagName('input')[0].value,
                description: rows[i].cells[3].getElementsByTagName('input')[0].value,
                quantity: rows[i].cells[4].getElementsByTagName('input')[0].value,
                amount: rows[i].cells[5].getElementsByTagName('input')[0].value,
                markup: rows[i].cells[6].getElementsByTagName('input')[0].value,
                total: rows[i].cells[7].getElementsByTagName('input')[0].value,
            };
            items.push(item);
        }
        document.getElementById('itemData').value = JSON.stringify(items);
    }

    // Fungsi untuk submit form setelah data item disimpan di input hidden
    function submitInvoice() {
        saveItem();
        document.getElementById('createinvoice').submit();
    }
</script>

<script>
    // Variabel untuk menghitung jumlah baris produk yang ditambahkan
    let rowCount = 0;

    // Fungsi untuk menambahkan baris produk baru
    function addRow() {
        rowCount++;

        let row = `
            <tr id="row${rowCount}">
                <td>${rowCount}</td>
                <td>
                    <select class="form-select" name="product[]">
                        @foreach ($products as $product)
                        <option value="{{ $product->name }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="item[]" class="form-control" placeholder="Item" required></td>
                <td><textarea type="text" name="description[]" class="form-control" placeholder="Description" required></textarea></td>
                <td><input type="number" name="quantity[]" class="form-control" placeholder="Quantity" onkeyup="calculateTotal(${rowCount})" required></td>
                <td><input type="number" name="amount[]" class="form-control" placeholder="Amount" onkeyup="calculateTotal(${rowCount})" required></td>
                <td><input type="number" name="markup[]" class="form-control" placeholder="Markup" onkeyup="calculateTotal(${rowCount})" required></td>
                <td><input type="number" name="total[]" class="form-control" placeholder="Total" readonly></td>
                <td><button type="button" class="btn btn-danger" onclick="removeRow(${rowCount})">Remove</button></td>
            </tr>
        `;

        document.getElementById("itemRows").insertAdjacentHTML("beforeend", row);
    }

    // Fungsi untuk menghitung total setiap baris produk
    function calculateTotal(rowNum) {
        let quantity = parseFloat(document.getElementsByName("quantity[]")[rowNum - 1].value);
        let amount = parseFloat(document.getElementsByName("amount[]")[rowNum - 1].value);
        let markup = parseFloat(document.getElementsByName("markup[]")[rowNum - 1].value);
        let total = quantity * (amount + markup);
        if (!isNaN(total)) {
            document.getElementsByName("total[]")[rowNum - 1].value = total;
        }
    }

    // Fungsi untuk menghapus baris produk
    function removeRow(rowNum) {
        document.getElementById("row" + rowNum).remove();
    }

    // Fungsi untuk mengumpulkan data dan menyimpannya ke database melalui Ajax
    function submitInvoice() {
        let form = document.getElementById("createinvoice");
        let formData = new FormData(form);

        axios.post("{{ route('invoice.store') }}", formData)
            .then(response => {
                // Redirect ke halaman index atau lakukan apa yang diperlukan setelah penyimpanan berhasil
                window.location.href = "{{ route('invoice.index') }}";
            })
            .catch(error => {
                // Handle error jika ada
            });
    }
</script> -->



<!-- <script>
    // simpan dilocal storage
    document.getElementById('createinvoice').addEventListener('submit', function(event) {
        event.preventDefault();

        const invoice_number = document.getElementById('invoice_number').value;
        const customer_id = document.getElementById('customer_id').value;
        const product = document.getElementById('product').value;
        const item = document.getElementById('item').value;
        const description = document.getElementById('description').value;
        const quantity = document.getElementById('quantity').value;
        const amount = document.getElementById('amount').value;
        const markup = document.getElementById('markup').value;
        const total = document.getElementById('total').value;
        const status = document.getElementById('status').checked;

        // Cek apakah sudah ada data di Local Storage
        let data = JSON.parse(localStorage.getItem('data') || '[]');

        // Hitung nomor urut untuk data baru
        const newId = data.length + 1;

        // Tambahkan data baru
        data.push({
            id: newId,
            invoice_number: invoice_number,
            customer_id: customer_id,
            product: product,
            item: item,
            description: description,
            quantity: quantity,
            amount: amount,
            markup: markup,
            total: total,
            status: status,
        });

        // Simpan data kembali ke Local Storage
        localStorage.setItem('data', JSON.stringify(data));

        // Reset form jika diperlukan
        event.target.reset();

        // Tampilkan data dari Local Storage
        displayData();
    });

    // Function untuk menampilkan data dari Local Storage ke halaman
    function displayData() {
        const data = JSON.parse(localStorage.getItem('data') || '[]');
        const tbody = document.querySelector('#dataTable tbody');
        tbody.innerHTML = ''; // Clear existing data

        data.forEach(item => {
            const row = document.createElement('tr');

            const idCell = document.createElement('td');
            idCell.textContent = item.id;
            row.appendChild(idCell);

            const invoice_numberCell = document.createElement('td');
            invoice_numberCell.textContent = item.invoice_number;
            row.appendChild(invoice_numberCell);

            const customer_idCell = document.createElement('td');
            customer_idCell.textContent = item.customer_id;
            row.appendChild(customer_idCell);

            const productCell = document.createElement('td');
            productCell.textContent = item.product;
            row.appendChild(productCell);

            const itemCell = document.createElement('td');
            itemCell.textContent = item.item;
            row.appendChild(itemCell);

            const descriptionCell = document.createElement('td');
            descriptionCell.textContent = item.description;
            row.appendChild(descriptionCell);

            const quantityCell = document.createElement('td');
            quantityCell.textContent = item.quantity;
            row.appendChild(quantityCell);

            const amountCell = document.createElement('td');
            amountCell.textContent = item.amount;
            row.appendChild(amountCell);

            const markupCell = document.createElement('td');
            markupCell.textContent = item.markup;
            row.appendChild(markupCell);

            const totalCell = document.createElement('td');
            totalCell.textContent = item.total;
            row.appendChild(totalCell);

            const statusCell = document.createElement('td');
            statusCell.textContent = item.status ? 'True' : 'False';
            row.appendChild(statusCell);

            // Tambahkan sel data lain sesuai kebutuhan

            tbody.appendChild(row);
        });
    }
    // clear data ketika direfresh atau pergi kehalaman lainnya
    localStorage.clear()

    // menyimpan kedatabase dari local storage
    function saveToDatabase() {
        const data = JSON.parse(localStorage.getItem('data') || '[]');

        // Ubah nilai status dari "true" dan "false" menjadi boolean (true dan false)
        data.forEach(item => {
            item.status = item.status ? 'True' : 'False';
        });

        fetch("{{ route('invoice.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (response.ok) {
                    // Reset local storage karena data telah berhasil disimpan
                    localStorage.removeItem('data');
                    // Redirect ke halaman indeks atau lakukan tindakan lain yang Anda butuhkan
                    window.location.href = "{{ route('invoice.index') }}";
                } else {
                    // Tangani respons error
                    return response.json().then(errorData => {
                        console.error('Error:', errorData);
                        // Anda bisa menampilkan pesan error kepada pengguna atau lakukan tindakan lain
                    });
                }
            })
            .catch(error => {
                console.error('Gagal menyimpan data:', error);
            });
    }
</script> -->



@endsection