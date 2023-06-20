@extends('pengguna.layout')
 
@section('content')
    <div class="row mt-5">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Users</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-success" href="{{ route('pengguna.create') }}"> Create New Users</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Phone</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($pengguna as $pna)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $pna->name }}</td>
            <td>{{ $pna->email }}</td>
            <td>{{ $pna->phone }}</td>
            <td>
                <form action="{{ route('pengguna.destroy',$pna->id) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('pengguna.show',$pna->id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('pengguna.edit',$pna->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    <div class="row text-center">
        {!! $pengguna->links() !!}
    </div>
      
@endsection