<!-- Modal -->         
                <div class="modal fade" id="exampleModalCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Customers</h5>
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
                        <form action="{{ route('customer.store') }}" method="POST">
                            @csrf

                            <div class="container px-4">
                                <div class="col-lg-12 margin-tb">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        <input type="text" name="name" class="form-control" placeholder="Name">
                                    </div>
                                </div>
                            </div>
                            <div class="container mt-3 px-4">
                                <div class="col-lg-12 margin-tb">
                                    <div class="form-group">
                                        <strong>Phone:</strong>
                                        <input type="text" name="phone" class="form-control" placeholder="Phone">
                                    </div>
                                </div>
                            </div>
                            <div class="container mt-3 px-4">
                                <div class="col-lg-12 margin-tb">
                                    <div class="form-group">
                                        <strong>Email:</strong>
                                        <input type="text" name="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                            <div class="container mt-3 px-4">
                                <div class="col-lg-12 margin-tb">
                                    <div class="form-group">
                                        <strong>Address:</strong>
                                        <input class="form-control" name="address" placeholder="Address"></input>
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
                        </div>
                    </div>
                </div>
                        </form>
                </div>
            </div>                         
<!-- endcontent create-->