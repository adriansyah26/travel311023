<!-- Modal -->

<div class="modal fade" id="exampleModalEdit-{{ $tpe->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- content edit -->
            <div class="modal-body">
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
                <form action="{{ route('type.update', $tpe->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="container px-4">
                        <div class="col-lg-12 margin-tb">
                            <div class="form-group">
                                <strong>Code:</strong>
                                <input class="form-control" name="code" placeholder="Code" value="{{ $tpe->code }}">
                            </div>
                        </div>
                    </div>
                    <div class="container px-4">
                        <div class="col-lg-12 margin-tb">
                            <div class="form-group">
                                <strong>Name:</strong>
                                <input type="text" name="name" value="{{ $tpe->name }}" class="form-control" placeholder="Name">
                            </div>
                        </div>
                    </div>
                    <div class="container mt-3">
                        <div class="col-lg-12 margin-tb">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- endcontent edit -->