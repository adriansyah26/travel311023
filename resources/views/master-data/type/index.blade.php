@extends('layout.app')
@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="float-start mt-3">
            <h2>Type</h2>
        </div>
        <div class="col-lg-12 margin-tb">
            <div class="float-end mt-3">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createTypeModal"><i class="bi bi-file-earmark-plus"></i> New Type</button>
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
                    <tbody id="RowsType">
                        @foreach ($type as $i => $tpe)
                        <tr data-type-id="{{ $tpe->id }}">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $tpe->code }}</td>
                            <td>{{ $tpe->name }}</td>
                            <td>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editTypeModal" onclick="editTypeModal('{{ $tpe->id }}')"><i class="bi bi-pencil-square"></i></button>
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
    <div class="modal fade" id="createTypeModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add New Type</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="card col-lg-12">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>Code</strong>
                                            <div class="input-group">
                                                <input type="text" name="code" class="form-control" placeholder="Code 4 Characters" value="{{ old('code') }}" id="code" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>Name</strong>
                                            <div class="input-group">
                                                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" id="name" required>
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
                    <button type="button" class="btn btn-success" onclick="SaveType()">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal Edit-->
    <div class="modal fade" id="editTypeModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Type</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="card col-lg-12">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>Code</strong>
                                            <div class="input-group">
                                                <input type="text" name="codeedit" class="form-control" placeholder="Code 4 Characters" id="codeedit" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>Name</strong>
                                            <div class="input-group">
                                                <input type="text" name="nameedit" class="form-control" placeholder="Name" id="nameedit" required>
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
                    <button type="button" class="btn btn-success" id="updateTypeModal" onclick="UpdateType()">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function SaveType() {
        const code = document.getElementById('code').value;
        const name = document.getElementById('name').value;

        const formData = new FormData();
        formData.append('code', code);
        formData.append('name', name);

        axios.post("{{ route('type.store') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if (response.data.success) {
                    // Membersihkan isian input modal setelah berhasil menyimpan data
                    document.getElementById('code').value = '';
                    document.getElementById('name').value = '';

                    $('#createTypeModal').modal('hide');
                    // Menampilkan SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Type created successfully',

                    }).then(() => {
                        // Melakukan refresh halaman
                        location.reload();
                    });

                    // mengubah table setelah disimpan
                    UpdateTable(response.data.type);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed created type!',
                    });
                }
            })
            .catch(function(error) {
                console.error('Gagal menyimpan data:', error);
            });
    }

    function UpdateTable(type) {
        const table = $('#table').DataTable(); // Dapatkan objek DataTable

        // Membuat HTML untuk satu baris tabel dengan data yang diterima
        const tableRowHTML = `
            <tr data-type-id="${type.id}">
                <td></td> <!-- Selalu set nomor urutan ke 1 untuk data baru -->
                <td>${type.code}</td>
                <td>${type.name}</td>
                <td>
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editTypeModal" onclick="editTypeModal('${type.id}')"><i class="bi bi-pencil-square"></i></button>
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
    function editTypeModal(typeId) {
        axios.get(`/type/edit-type/${typeId}`)
            .then(response => {
                if (response.data.success) {
                    const type = response.data.type;
                    document.getElementById('codeedit').value = type.code;
                    document.getElementById('nameedit').value = type.name;

                    // Simpan typeId dalam atribut data-type-id pada tombol "Edit" dalam modal
                    const updateTypeModal = document.getElementById('updateTypeModal');
                    updateTypeModal.setAttribute('data-type-id', typeId);

                    $('#editTypeModal').modal('show');
                } else {
                    console.error('Gagal mengambil data type untuk edit');
                }
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
            });
    }
</script>

<script>
    function UpdateType() {
        const typeId = document.getElementById('updateTypeModal').getAttribute('data-type-id'); // Dapatkan ID type yang akan diperbarui

        const codeedit = document.getElementById('codeedit').value;
        const nameedit = document.getElementById('nameedit').value;

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('codeedit', codeedit);
        formData.append('nameedit', nameedit);

        axios.post(`/type/update-type/${typeId}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if (response.data.success) {
                    // Semua pembaruan berhasil, perbarui tabel dengan versi terbaru
                    const updateTableEdit = response.data.type;
                    if (updateTableEdit && updateTableEdit.id) {
                        // Panggil fungsi updateTableRow untuk memperbarui tampilan tabel
                        updateTableRow(updateTableEdit);

                        $('#editTypeModal').modal('hide');
                    } else {
                        console.error('Type yang diperbarui tidak memiliki ID yang valid.');
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
                    console.error('Gagal memperbarui type:', response.data.message);
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed updated type!',
                });
                console.error('Terjadi kesalahan:', error);
            });
    }
</script>

<script>
    // mengubah table setelah diupdate
    function updateTableRow(updateTableEdit) {
        const typeRowsContainer = document.getElementById('RowsType');
        const updatedRow = typeRowsContainer.querySelector(`tr[data-type-id="${updateTableEdit.id}"]`);
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