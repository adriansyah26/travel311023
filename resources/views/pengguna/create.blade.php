<!-- Modal -->         
                <div class="modal fade" id="exampleModalCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Users</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
<!-- content create-->
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
                        <form action="{{ route('pengguna.store') }}" method="POST">
                            @csrf
                        
                            <div class="container px-4">
                                <div class="col-lg-12 margin-tb">
                                    <div class="form-group">
                                        <strong>Nama:</strong>
                                        <input type="text" name="name" class="form-control" placeholder="Nama">
                                    </div>
                                </div>
                            </div>
                            <div class="container mt-3 px-4">
                                <div class="col-lg-12 margin-tb">
                                    <div class="form-group">
                                        <strong>Email:</strong>
                                        <input class="form-control" name="email" placeholder="Email"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="container mt-3 px-4">
                                <div class="col-lg-12 margin-tb">
                                    <div class="form-group">
                                        <strong>Phone:</strong>
                                        <input class="form-control" name="phone" placeholder="Phone"></input>
                                    </div>
                                </div>
                            </div>                              
                </div>
                                    <div class="modal-footer px-4">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>                                               
                        </div>
                    </div>
                </div>
                        </form>
                </div>
            </div>                         
<!-- endcontent create-->