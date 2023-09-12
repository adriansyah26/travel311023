@extends('layout.apps')
@section('content')
<main>
    <div class="container mt-3 px-4">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Users</h2>
            </div>
            <div class="container mt-3 px-4">
                <div class="col-lg-12 margin-tb">
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('user.create') }}"><i class="bi bi-file-earmark-plus"></i> New Users</a>
                    </div>
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
                                <th style="width: 40px;">Title</th>
                                <th style="width: 150px;">First Name</th>
                                <th style="width: 150px;">Last Name</th>
                                <th style="width: 100px;">Phone</th>
                                <th style="width: 200px;">Email</th>
                                <th style="width: 70px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $i => $user)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $user->title }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="d-flex">
                                        <!-- <a class="btn btn-info me-1" href="{{ route('user.show',$user->id) }}">Show</a> -->
                                        <a class="btn btn-primary me-1" href="{{ route('user.edit',$user->id) }}"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('user.destroy',$user->id) }}" method="POST" class="delete-form">
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
    </div>
</main>

<script>
    // Menggunakan SweetAlert2 untuk konfirmasi penghapusan
    document.addEventListener('DOMContentLoaded', function() {
        let deleteForms = document.querySelectorAll('form.delete-form');

        deleteForms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
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
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection