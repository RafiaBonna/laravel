@extends('master')
@section('content')
<div class="card">
  <div class="header pb-5 pt-5 pt-lg-8 d-flex align-items-center"
    style="min-height: 50px; background-image: url(../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
    <span class="mask bg-gradient-default opacity-8"></span>
    <div class="container-fluid d-flex align-items-center">
      <div class="row align-items-center">
        <div class="col-lg-12 col-md-10 text-center">
          <h1 class="display-2 text-white text-center">Supplier List</h1>
          <a href="{{ route('supplier.create') }}" class="btn btn-info">Add Supplier</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container mt-4">
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Address</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($suppliers as $s)
      <tr>
        <th scope="row">{{ $loop->iteration }}</th>
        <td>{{ $s->name }}</td>
        <td>{{ $s->email }}</td>
        <td>{{ $s->phone }}</td>
        <td>{{ $s->address }}</td>
        <td>
          <div class="btn-group">
            <a href="{{ route('supplier.edit', $s->id) }}" class="btn btn-success btn-sm me-1 p-1"><i class="bi bi-pencil-square"></i></a>
            <form action="{{ route('supplier.delete') }}" method="POST">
              @method('DELETE')
              @csrf
              <input type="hidden" name="supplier_id" value="{{ $s->id }}">
              <button type="submit" class="btn btn-danger btn-sm p-1"><i class="bi bi-trash3-fill"></i></button>
            </form>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
