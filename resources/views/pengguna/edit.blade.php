<!-- Modal --> 
    
<div class="modal fade" id="exampleModalEdit-{{ $pna->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Users</h5>
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
            <form action="{{ route('pengguna.update', $pna->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="container px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Title:</strong>
                            <div class="input-group mb-3">
                                <select class="form-select" name="title" value="{{ old('title') }}">
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>First Name:</strong>
                            <input type="text" name="first_name" value="{{ $pna->first_name }}" class="form-control" placeholder="First Name" value="{{ old('first_name') }}">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Last Name:</strong>
                            <input type="text" name="last_name" value="{{ $pna->last_name }}" class="form-control" placeholder="Last Name" value="{{ old('last_name') }}">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Phone:</strong>
                            <input class="form-control" name="phone" placeholder="Phone" type="number" value="{{ $pna->phone }}" value="{{ old('phone') }}">
                        </div>
                    </div>
                </div>
                <div class="container mt-3 px-4">
                    <div class="col-lg-12 margin-tb">
                        <div class="form-group">
                            <strong>Email:</strong>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                                placeholder="name@example.com" value="{{ $pna->email }}" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
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