@extends('layout.apps')
@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="float-start mt-3">
            <h2>Customers</h2>
        </div>
        <div class="col-lg-12 margin-tb">
            <div class="float-end mt-3">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createCustomerModal"><i class="bi bi-file-earmark-plus"></i> New Customers</button>
            </div>
        </div>

        <div class="row container mt-1 px-4">
            @if ($message = Session::get('success'))
            <div class="alert alert-success container mt-1 px-4">
                <p>{{ $message }}</p>
            </div>
            @endif
        </div>
        <div class="card mb-4 mt-3 px-4">
            <div class="card-body" style="overflow-x: auto;">
                <table id="table" class="table table-striped table-bordered" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <th style="width: 30px;">No</th>
                            <th style="width: 150px;">Name</th>
                            <th style="width: 100px;">Phone</th>
                            <th style="width: 200px;">Email</th>
                            <th style="width: 58px;">Termin</th>
                            <th style="width: 250px;">Address</th>
                            <th style="width: 80px;">Type</th>
                            <th style="width: 50px;">Action</th>
                        </tr>
                    </thead>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <tbody id="RowsCustomer">
                        @foreach ($customer as $i => $cst)
                        <tr data-customer-id="{{ $cst->id }}">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $cst->name }}</td>
                            <td>{{ $cst->phone }}</td>
                            <td>{{ $cst->email }}</td>
                            <td>{{ $cst->termin }}</td>
                            <td>{{ $cst->address }}</td>
                            <td>{{ $cst->type_id ? $types->find($cst->type_id)->name : 'Nama tidak ditemukan' }}</td>
                            <td>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editCustomerModal" onclick="editCustomerModal('{{ $cst->id }}')"><i class="bi bi-pencil-square"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- The Modal Create-->
    <div class="modal fade bd-example-modal-lg" id="createCustomerModal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add New Customers</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="card col-lg-12 ">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-6 margin-tb">
                                        <div class="form-group">
                                            <strong>Name</strong>
                                            <div class="input-group">
                                                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" id="name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 margin-tb">
                                        <div class="form-group">
                                            <strong>Phone</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="phone" placeholder="Phone" type="number" value="{{ old('phone') }}" id="phone" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-6 margin-tb">
                                        <div class="form-group">
                                            <strong>Email</strong>
                                            <div class="input-group">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="name@example.com" value="{{ old('email') }}" id="email" required>
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 margin-tb">
                                        <div class="form-group">
                                            <strong>Termin</strong>
                                            <div class="input-group">
                                                <input type="text" name="termin" class="form-control" placeholder="Termin" value="{{ old('termin') }}" id="termin" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="col-lg-6 margin-tb">
                                        <div class="form-group">
                                            <strong>Address</strong>
                                            <div class="input-group">
                                                <textarea class="form-control" name="address" placeholder="Address" id="address" required>{{ old('address') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 margin-tb">
                                        <div class="form-group">
                                            <strong>Type</strong>
                                            <div class="input-group">
                                                <select class="form-select" name="type_name" id="type_id" data-types="{{ json_encode($types) }}">
                                                    @foreach ($types as $type)
                                                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
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
                    <button type="button" class="btn btn-success" onclick="SaveCustomer()">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal Edit-->
    <div class="modal fade bd-example-modal-lg" id="editCustomerModal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit New Customers</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="card col-lg-12 ">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-6 margin-tb">
                                        <div class="form-group">
                                            <strong>Name</strong>
                                            <div class="input-group">
                                                <input type="text" name="nameedit" class="form-control" placeholder="Name" id="nameedit" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 margin-tb">
                                        <div class="form-group">
                                            <strong>Phone</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="phoneedit" placeholder="Phone" type="number" id="phoneedit" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-6 margin-tb">
                                        <div class="form-group">
                                            <strong>Email</strong>
                                            <div class="input-group">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="emailedit" placeholder="name@example.com" id="emailedit" required>
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 margin-tb">
                                        <div class="form-group">
                                            <strong>Termin</strong>
                                            <div class="input-group">
                                                <input type="text" name="terminedit" class="form-control" placeholder="Termin" id="terminedit" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="col-lg-6 margin-tb">
                                        <div class="form-group">
                                            <strong>Address</strong>
                                            <div class="input-group">
                                                <textarea class="form-control" name="addressedit" placeholder="Address" id="addressedit" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 margin-tb">
                                        <div class="form-group">
                                            <strong>Type</strong>
                                            <div class="input-group">
                                                <div class="input-group">
                                                    <select class="form-select" name="type_name_edit" id="type_id_edit" data-types-edit="{{ json_encode($types) }}">
                                                        @foreach ($types as $type)
                                                        <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
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
                    <button type="button" class="btn btn-success" id="updateCustomerModal" onclick="UpdateCustomer()">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Ambil data produk dari tag HTML
    const typesData = JSON.parse(document.getElementById('type_id').getAttribute('data-types'));

    function SaveCustomer() {
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const email = document.getElementById('email').value;
        const termin = document.getElementById('termin').value;
        const typeId = document.getElementById('type_id').value;
        const address = document.getElementById('address').value;

        const formData = new FormData();
        formData.append('name', name);
        formData.append('phone', phone);
        formData.append('email', email);
        formData.append('termin', termin);
        formData.append('type_id', typeId);
        formData.append('address', address);

        axios.post("{{ route('customer.store') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if (response.data.success) {
                    // Membersihkan isian input modal setelah berhasil menyimpan data
                    document.getElementById('name').value = '';
                    document.getElementById('phone').value = '';
                    document.getElementById('email').value = '';
                    document.getElementById('termin').value = '';
                    document.getElementById('type_id').value = '';
                    document.getElementById('address').value = '';

                    $('#createCustomerModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Customers created successfully',
                    }).then(() => {
                        // Melakukan refresh halaman
                        location.reload();
                    });
                    // Update the table with the new data
                    UpdateTable(response.data.customer);

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed created customers!',
                    });
                }
            })
            .catch(function(error) {
                console.error('Gagal menyimpan data:', error);
            });
    }

    function UpdateTable(customer) {
        const table = $('#table').DataTable(); // Dapatkan objek DataTable
        const typeName = typesData.find(type => type.id === parseInt(customer.type_id))?.name || 'types Tidak Tersedia';
        // Membuat HTML untuk satu baris tabel dengan data yang diterima
        const tableRowHTML = `
            <tr data-customer-id="${customer.id}">
                <td></td> <!-- Selalu set nomor urutan ke 1 untuk data baru -->
                <td>${customer.name}</td>
                <td>${customer.phone}</td>
                <td>${customer.email}</td>
                <td>${customer.termin}</td>
                <td>${customer.address}</td>
                <td>${typeName}</td>
                <td>
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editCustomerModal" onclick="editCustomerModal('${customer.id}')"><i class="bi bi-pencil-square"></i></button>
                    </div>
                </td>
            </tr>
            `;

        // Menambahkan baris baru ke dalam tabel menggunakan DataTable API
        table.row.add($(tableRowHTML)).draw();

        // Mengatur ulang nomor urutan
        resetRowNumbers();
    }

    function resetRowNumbers() {
        // Menggeser nomor urutan semua baris yang ada ke bawah
        $('#table tbody tr').each(function(index, row) {
            $(row).find('td:first').text(index + 1);
        });
    }
</script>

<script>
    function editCustomerModal(customerId) {
        axios.get(`/customer/edit-customer/${customerId}`)
            .then(response => {
                if (response.data.success) {
                    const customer = response.data.customer;
                    document.getElementById('nameedit').value = customer.name;
                    document.getElementById('phoneedit').value = customer.phone;
                    document.getElementById('emailedit').value = customer.email;
                    document.getElementById('terminedit').value = customer.termin;
                    document.getElementById('type_id_edit').value = customer.type_id;
                    document.getElementById('addressedit').value = customer.address;

                    // Simpan customerId dalam atribut data-customer-id pada tombol "Edit" dalam modal
                    const updateCustomerModal = document.getElementById('updateCustomerModal');
                    updateCustomerModal.setAttribute('data-customer-id', customerId);

                    $('#editCustomerModal').modal('show');
                } else {
                    console.error('Gagal mengambil data customer untuk edit');
                }
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
            });
    }
</script>

<script>
    function UpdateCustomer() {
        const customerId = document.getElementById('updateCustomerModal').getAttribute('data-customer-id'); // Dapatkan ID customer yang akan diperbarui

        const nameedit = document.getElementById('nameedit').value;
        const phoneedit = document.getElementById('phoneedit').value;
        const emailedit = document.getElementById('emailedit').value;
        const terminedit = document.getElementById('terminedit').value;
        const type_id_edit = document.getElementById('type_id_edit').value;
        const addressedit = document.getElementById('addressedit').value;

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('nameedit', nameedit);
        formData.append('phoneedit', phoneedit);
        formData.append('emailedit', emailedit);
        formData.append('terminedit', terminedit);
        formData.append('type_id_edit', type_id_edit);
        formData.append('addressedit', addressedit);

        axios.post(`/customer/update-customer/${customerId}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if (response.data.success) {
                    // Semua pembaruan berhasil, perbarui tabel dengan versi terbaru
                    const updateTableEdit = response.data.customer;
                    if (updateTableEdit && updateTableEdit.id) {
                        // Panggil fungsi updateTableRow untuk memperbarui tampilan tabel
                        updateTableRow(updateTableEdit);

                        $('#editCustomerModal').modal('hide');
                    } else {
                        console.error('Customer yang diperbarui tidak memiliki ID yang valid.');
                    }
                    // Lakukan pembaruan data dalam tabel jika diperlukan
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message,
                    }).then(() => {
                        // Melakukan refresh halaman
                        location.reload();
                    });
                } else {
                    console.error('Gagal memperbarui customer:', response.data.message);
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed updated customers!',
                });
                console.error('Terjadi kesalahan:', error);
            });
    }
</script>

<script>
    // Ambil data type dari tag HTML
    const typesDataedit = JSON.parse(document.getElementById('type_id_edit').getAttribute('data-types-edit'));
    // mengubah table setelah diupdate
    function updateTableRow(updateTableEdit) {
        const customerRowsContainer = document.getElementById('RowsCustomer');
        const updatedRow = customerRowsContainer.querySelector(`tr[data-customer-id="${updateTableEdit.id}"]`);
        if (updatedRow) {
            const columns = updatedRow.querySelectorAll('td'); // Ambil seluruh kolom dalam baris
            const typeName = typesDataedit.find(type => type.id === parseInt(updateTableEdit.type_id))?.name || 'types Tidak Tersedia';
            columns[1].textContent = updateTableEdit.name;
            columns[2].textContent = updateTableEdit.phone;
            columns[3].textContent = updateTableEdit.email;
            columns[4].textContent = updateTableEdit.termin;
            columns[5].textContent = updateTableEdit.address;
            columns[6].textContent = typeName;
        } else {
            console.error('Baris yang akan diperbarui tidak ditemukan.');
        }
    }
</script>
@endsection