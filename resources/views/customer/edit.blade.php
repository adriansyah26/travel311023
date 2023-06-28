<!-- Modal --> 
    
<div class="modal fade" id="exampleModalEdit-{{ $cst->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Customers</h5>
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
            <form action="{{ route('customer.update', $cst->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="container px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Name:</strong>
                            <input type="text" name="name" value="{{ $cst->name }}" class="form-control" placeholder="Name">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Phone:</strong>
                            <input class="form-control" name="phone" placeholder="Phone" value="{{ $cst->phone }}">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Email:</strong>
                            <input class="form-control" name="email" placeholder="Email" value="{{ $cst->email }}">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Address:</strong>
                            <input type="text" name="address" value="{{ $cst->address }}" class="form-control" placeholder="Address">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Type:</strong>
                                <div class="input-group mb-3">
                                    <select class="form-select" name="type">
                                        <option value="Personal">Personal</option>
                                        <option value="Corporate">Corporate</option>
                                        <option value="Goverenment">Goverenment</option>
                                    </select>
                                </div>
                        </div>
                    </div>
                </div>             
                </div>
                <div class="container mt-1 px-4">
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

<!-- endcontent edit -->