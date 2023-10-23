@extends('layout.app')
@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="float-start mt-3">
            <h2>Products</h2>
        </div>
        <div class="col-lg-12 margin-tb">
            <div class="float-end mt-3">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createProductModal"><i class="bi bi-file-earmark-plus"></i> New Products</button>
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
                            <th style="width: 100px;">Code</th>
                            <th style="width: 690px;">Name</th>
                            <th style="width: 50px;">Action</th>
                        </tr>
                    </thead>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <tbody id="RowsProduct">
                        @foreach ($product as $i => $pdt)
                        <tr data-product-id="{{ $pdt->id }}">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $pdt->code }}</td>
                            <td>{{ $pdt->name }}</td>
                            <td>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editProductModal" onclick="editProductModal('{{ $pdt->id }}')"><i class="bi bi-pencil-square"></i></button>
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
    <div class="modal fade" id="createProductModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add New Products</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="card col-lg-12 ">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12 margin-tb">
                                        <div class="form-group">
                                            <strong>Code</strong>
                                            <div class="input-group mb-3">
                                                <input type="text" name="code" class="form-control" placeholder="Code 4 Characters" value="{{ old('code') }}" id="code" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 margin-tb">
                                        <div class="form-group">
                                            <strong>Name</strong>
                                            <div class="input-group mb-3">
                                                <input type="text" name="name" class="form-control" placeholder="Don't Same Other Name" value="{{ old('name') }}" id="name" required>
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
                    <button type="button" class="btn btn-success" onclick="SaveProduct()">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal Edit-->
    <div class="modal fade" id="editProductModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit New Products</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="card col-lg-12 ">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12 margin-tb">
                                        <div class="form-group">
                                            <strong>Code</strong>
                                            <div class="input-group mb-3">
                                                <input type="text" name="codeedit" class="form-control" placeholder="Code 4 Characters" id="codeedit" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 margin-tb">
                                        <div class="form-group">
                                            <strong>Name</strong>
                                            <div class="input-group mb-3">
                                                <input type="text" name="nameedit" class="form-control" placeholder="Don't Same Other Name" id="nameedit" required>
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
                    <button type="button" class="btn btn-success" id="updateProductModal" onclick="UpdateProduct()">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function SaveProduct() {
        const code = document.getElementById('code').value;
        const name = document.getElementById('name').value;

        const formData = new FormData();
        formData.append('code', code);
        formData.append('name', name);

        axios.post("{{ route('product.store') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if (response.data.success) {
                    // Membersihkan isian input modal setelah berhasil menyimpan data
                    document.getElementById('code').value = '';
                    document.getElementById('name').value = '';

                    $('#createProductModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Products created successfully',
                    }).then(() => {
                        // Melakukan refresh halaman
                        location.reload();
                    });
                    // Update the table with the new data
                    UpdateTable(response.data.product);

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed created products!',
                    });
                }
            })
            .catch(function(error) {
                console.error('Gagal menyimpan data:', error);
            });
    }

    function UpdateTable(product) {
        const table = $('#table').DataTable(); // Dapatkan objek DataTable

        // Membuat HTML untuk satu baris tabel dengan data yang diterima
        const tableRowHTML = `
            <tr data-product-id="${product.id}">
                <td></td> <!-- Selalu set nomor urutan ke 1 untuk data baru -->
                <td>${product.code}</td>
                <td>${product.name}</td>
                <td>
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editProductModal" onclick="editProductModal('${product.id}')"><i class="bi bi-pencil-square"></i></button>
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
    function editProductModal(productId) {
        axios.get(`/product/edit-product/${productId}`)
            .then(response => {
                if (response.data.success) {
                    const product = response.data.product;
                    document.getElementById('codeedit').value = product.code;
                    document.getElementById('nameedit').value = product.name;

                    // Simpan productId dalam atribut data-product-id pada tombol "Edit" dalam modal
                    const updateProductModal = document.getElementById('updateProductModal');
                    updateProductModal.setAttribute('data-product-id', productId);

                    $('#editProductModal').modal('show');
                } else {
                    console.error('Gagal mengambil data product untuk edit');
                }
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
            });
    }
</script>

<script>
    function UpdateProduct() {
        const productId = document.getElementById('updateProductModal').getAttribute('data-product-id'); // Dapatkan ID product yang akan diperbarui

        const codeedit = document.getElementById('codeedit').value;
        const nameedit = document.getElementById('nameedit').value;

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('codeedit', codeedit);
        formData.append('nameedit', nameedit);

        axios.post(`/product/update-product/${productId}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if (response.data.success) {
                    // Semua pembaruan berhasil, perbarui tabel dengan versi terbaru
                    const updateTableEdit = response.data.product;
                    if (updateTableEdit && updateTableEdit.id) {
                        // Panggil fungsi updateTableRow untuk memperbarui tampilan tabel
                        updateTableRow(updateTableEdit);

                        $('#editProductModal').modal('hide');
                    } else {
                        console.error('Product yang diperbarui tidak memiliki ID yang valid.');
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
                    console.error('Gagal memperbarui product:', response.data.message);
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed updated products!',
                });
                console.error('Terjadi kesalahan:', error);
            });
    }
</script>

<script>
    // mengubah table setelah diupdate
    function updateTableRow(updateTableEdit) {
        const productRowsContainer = document.getElementById('RowsProduct');
        const updatedRow = productRowsContainer.querySelector(`tr[data-product-id="${updateTableEdit.id}"]`);
        if (updatedRow) {
            const columns = updatedRow.querySelectorAll('td'); // Ambil seluruh kolom dalam baris
            columns[1].textContent = updateTableEdit.code;
            columns[2].textContent = updateTableEdit.name;
        } else {
            console.error('Baris yang akan diperbarui tidak ditemukan.');
        }
    }
</script>
@endsection