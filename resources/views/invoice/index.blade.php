@extends('layout.apps')
@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="float-start mt-3">
            <h2>Invoice</h2>
            <div class="form-check col-lg-7" style="margin-left: 120px; margin-top: -40px;">
                <select class="form-select" aria-label="Default select example" id="pdfDropdown" style="cursor: pointer;">
                    <option value="select" id="select" selected>--Select PDF--</option>
                    <option value="rizkyksp" id="rizkyksp">RIZKY KSP</option>
                    <option value="dickyksp" id="dickyksp">DICKY KSP</option>
                    <option value="dickymaxx" id="dickymaxx">DICKY MAXX</option>
                </select>
            </div>
        </div>
        <div class="col-lg-12 margin-tb">
            <div class="float-end mt-3">
                <a class="btn btn-success" href="{{ route('invoice.create') }}"><i class="bi bi-file-earmark-plus"></i> New Invoice</a>
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
                <table id="table" class="table  table-striped table-bordered" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <th style="width: 30px;">No</th>
                            <th style="width: 150px;">Invoice Number</th>
                            <th style="width: 465px;">Customers Name</th>
                            <th style="width: 50px;">Status</th>
                            <th style="width: 60px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice as $i => $ive)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $ive->invoice_number }}</td>
                            <td>{{ $ive->customer->name }}</td>
                            <td>{{ $ive->status }}</td>
                            <td>
                                <div class="d-flex">
                                    <a class="btn btn-primary me-1" href="{{ route('invoice.edit',$ive->id) }}"><i class="bi bi-pencil-square"></i></a>
                                    <!-- <a class="btn btn-info me-1" target="blank" href="{{ route('invoice.show',$ive->id) }}"><i class="bi bi-filetype-pdf text-white"></i></a> -->
                                    <a class="btn btn-info me-1 view-pdf-button" target="blank" href="{{ route('invoice.show',$ive->id) }}" data-id="{{ $ive->id }}"><i class="bi bi-filetype-pdf text-white"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
    // Dapatkan elemen dropdown
    const dropdown = document.getElementById('pdfDropdown');

    // Tambahkan event listener untuk memantau perubahan dropdown
    dropdown.addEventListener('change', function() {
        const selectedValue = dropdown.value;

        // Dapatkan semua tombol "View PDF"
        const pdfButtons = document.querySelectorAll('.view-pdf-button');

        // Perbarui URL di setiap tombol sesuai dengan pilihan dropdown
        pdfButtons.forEach(button => {
            const invoiceId = button.getAttribute('data-id');
            button.href = "{{ route('invoice.show', '') }}/" + invoiceId + "?pdf=" + selectedValue;
        });
    });
</script>

@endsection