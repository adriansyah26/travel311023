@extends('layout.apps')
@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="float-start mt-3">
            <h2>Users</h2>
        </div>
        <div class="col-lg-12 margin-tb">
            <div class="float-end mt-3">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUserModal"><i class="bi bi-file-earmark-plus"></i> New Users</button>
            </div>
        </div>

        <div class="row container mt-1 px-4">
            <!-- @if ($message = Session::get('success'))
            <div class="alert alert-success container mt-1 px-4">
                <p>{{ $message }}</p>
            </div>
            @endif -->
        </div>
        <div class="card mb-4 mt-3 px-4">
            <div class="card-body" style="overflow-x: auto;">
                <table id="table" class="table table-striped table-bordered" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <th style="width: 30px;">No</th>
                            <th style="width: 40px;">Title</th>
                            <th style="width: 150px;">First Name</th>
                            <th style="width: 150px;">Last Name</th>
                            <th style="width: 100px;">Phone</th>
                            <th style="width: 200px;">Email</th>
                            <th style="width: 70px;">Action</th>
                        </tr>
                    </thead>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <tbody id="RowsUser">
                        @foreach ($users as $i => $user)
                        <tr data-user-id="{{ $user->id }}">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $user->title }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="editUserModal('{{ $user->id }}')"><i class="bi bi-pencil-square"></i></button>
                                    <form action="{{ route('user.destroy',$user->id) }}" method="POST" class="delete-form" data-user-id="{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger me-1"><i class="bi bi-trash"></i></button>
                                    </form>

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
    <div class="modal fade bd-example-modal-lg" id="createUserModal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add New Users</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="card col-lg-12">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-2 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>Title</strong>
                                            <div class="input-group">
                                                <select class="form-select" name="title" value="{{ old('title') }}" id="title">
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mrs">Mrs</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>First Name</strong>
                                            <div class="input-group">
                                                <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name') }}" id="first_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>Last Name</strong>
                                            <div class="input-group">
                                                <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name') }}" id="last_name">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>Phone</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="phone" placeholder="Phone" type="number" value="{{ old('phone') }}" id="phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>Email</strong>
                                            <div class="input-group">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="name@gmail.com" value="{{ old('email') }}" id="email">
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
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
                    <button type="button" class="btn btn-success" onclick="SaveUser()">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal Edit-->
    <div class="modal fade bd-example-modal-lg" id="editUserModal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Users</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="card col-lg-12">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-2 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>Title</strong>
                                            <div class="input-group">
                                                <select class="form-select" name="title" value="{{ old('title') }}" id="titleedit">
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mrs">Mrs</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>First Name</strong>
                                            <div class="input-group">
                                                <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name') }}" id="first_name_edit">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>Last Name</strong>
                                            <div class="input-group">
                                                <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name') }}" id="last_name_edit">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>Phone</strong>
                                            <div class="input-group">
                                                <input class="form-control" name="phone" placeholder="Phone" type="number" value="{{ old('phone') }}" id="phoneedit">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 margin-tb mb-3">
                                        <div class="form-group">
                                            <strong>Email</strong>
                                            <div class="input-group">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="name@gmail.com" value="{{ old('email') }}" id="emailedit">
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
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
                    <button type="button" class="btn btn-success" id="updateUserModal" onclick="UpdateUser()">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let deleteForms = document.querySelectorAll('form.delete-form');

        deleteForms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let userId = form.getAttribute('data-user-id');
                let rowToDelete = form.closest('tr'); // Mengambil baris yang akan dihapus

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Data will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/user/${userId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    rowToDelete.remove(); // Menghapus baris dari tabel

                                    // Mengupdate nomor urut
                                    let table = document.querySelector('#table');
                                    let rows = table.querySelectorAll('tbody tr');

                                    rows.forEach((row, index) => {
                                        let cells = row.querySelectorAll('td');
                                        cells[0].textContent = index + 1;
                                    });

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: 'Users deleted successfully',
                                    }).then(() => {
                                        // Melakukan refresh halaman
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Failed deleted users',
                                    });
                                }
                            });
                    }
                });
            });
        });
    });
</script>

<script>
    function SaveUser() {
        const title = document.getElementById('title').value;
        const first_name = document.getElementById('first_name').value;
        const last_name = document.getElementById('last_name').value;
        const phone = document.getElementById('phone').value;
        const email = document.getElementById('email').value;

        const formData = new FormData();
        formData.append('title', title);
        formData.append('first_name', first_name);
        formData.append('last_name', last_name);
        formData.append('phone', phone);
        formData.append('email', email);

        axios.post("{{ route('user.store') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if (response.data.success) {
                    // Membersihkan isian input modal setelah berhasil menyimpan data
                    document.getElementById('title').value = '';
                    document.getElementById('first_name').value = '';
                    document.getElementById('last_name').value = '';
                    document.getElementById('phone').value = '';
                    document.getElementById('email').value = '';

                    $('#createUserModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Users created successfully',
                    }).then(() => {
                        // Melakukan refresh halaman
                        location.reload();
                    });
                    // Update the table with the new data
                    UpdateTable(response.data.user);

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed created users!',
                    });
                }
            })
            .catch(function(error) {
                console.error('Gagal menyimpan data:', error);
            });
    }

    function UpdateTable(user) {
        const table = $('#table').DataTable(); // Dapatkan objek DataTable
        // Membuat HTML untuk satu baris tabel dengan data yang diterima
        const tableRowHTML = `
            <tr data-user-id="${user.id}">
                <td></td> <!-- Selalu set nomor urutan ke 1 untuk data baru -->
                <td>${user.title}</td>
                <td>${user.first_name}</td>
                <td>${user.last_name}</td>
                <td>${user.phone}</td>
                <td>${user.email}</td>
                <td>
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="editUserModal('${user.id}')"><i class="bi bi-pencil-square"></i></button>
                        <form action="{{ route('user.destroy', '') }}/${user.id}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger me-1"><i class="bi bi-trash"></i></button>
                        </form>
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
    function editUserModal(userId) {
        axios.get(`/user/edit-user/${userId}`)
            .then(response => {
                if (response.data.success) {
                    const user = response.data.user;
                    document.getElementById('titleedit').value = user.title;
                    document.getElementById('first_name_edit').value = user.first_name;
                    document.getElementById('last_name_edit').value = user.last_name;
                    document.getElementById('phoneedit').value = user.phone;
                    document.getElementById('emailedit').value = user.email;

                    // Simpan userId dalam atribut data-user-id pada tombol "Edit" dalam modal
                    const updateUserModal = document.getElementById('updateUserModal');
                    updateUserModal.setAttribute('data-user-id', userId);

                    $('#editUserModal').modal('show');
                } else {
                    console.error('Gagal mengambil data user untuk edit');
                }
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
            });
    }
</script>

<script>
    function UpdateUser() {
        const userId = document.getElementById('updateUserModal').getAttribute('data-user-id'); // Dapatkan ID user yang akan diperbarui

        const titleedit = document.getElementById('titleedit').value;
        const first_name_edit = document.getElementById('first_name_edit').value;
        const last_name_edit = document.getElementById('last_name_edit').value;
        const phoneedit = document.getElementById('phoneedit').value;
        const emailedit = document.getElementById('emailedit').value;

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('titleedit', titleedit);
        formData.append('first_name_edit', first_name_edit);
        formData.append('last_name_edit', last_name_edit);
        formData.append('phoneedit', phoneedit);
        formData.append('emailedit', emailedit);

        axios.post(`/user/update-user/${userId}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if (response.data.success) {
                    // Semua pembaruan berhasil, perbarui tabel dengan versi terbaru
                    const updateTableEdit = response.data.user;
                    if (updateTableEdit && updateTableEdit.id) {
                        // Panggil fungsi updateTableRow untuk memperbarui tampilan tabel
                        updateTableRow(updateTableEdit);

                        $('#editUserModal').modal('hide');
                    } else {
                        console.error('User yang diperbarui tidak memiliki ID yang valid.');
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
                    console.error('Gagal memperbarui user:', response.data.message);
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed updated users!',
                });
                console.error('Terjadi kesalahan:', error);
            });
    }
</script>

<script>
    // mengubah table setelah diupdate
    function updateTableRow(updateTableEdit) {
        const userRowsContainer = document.getElementById('RowsUser');
        const updatedRow = userRowsContainer.querySelector(`tr[data-user-id="${updateTableEdit.id}"]`);
        if (updatedRow) {
            const columns = updatedRow.querySelectorAll('td'); // Ambil seluruh kolom dalam baris
            columns[1].textContent = updateTableEdit.title;
            columns[2].textContent = updateTableEdit.first_name;
            columns[3].textContent = updateTableEdit.last_name;
            columns[4].textContent = updateTableEdit.phone;
            columns[5].textContent = updateTableEdit.email;
        } else {
            console.error('Baris yang akan diperbarui tidak ditemukan.');
        }
    }
</script>
@endsection