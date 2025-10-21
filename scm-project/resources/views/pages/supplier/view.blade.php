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
          <a href="{{ route('supplier.create') }}" class="btn btn-dark">Add Supplier</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container mt-4">
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
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
            {{-- ✅ ফিক্সড: d-flex ব্যবহার করা হলো --}}
            <div class="d-flex">
              
              {{-- 1. Edit Button: inline style (margin-right: 10px) ব্যবহার করে ব্যবধান নিশ্চিত করা হলো --}}
              <a href="{{ route('supplier.edit', $s->id) }}" 
                 class="btn btn-sm btn-primary" 
                 style="margin-right: 10px;" {{-- <-- এই লাইনটি মার্জিন নিশ্চিত করবে --}}
                 title="Edit Supplier: {{ $s->name }}">
                 <i class="fas fa-edit"></i> {{-- Font Awesome Icon --}}
              </a>
              
              {{-- 2. Delete Button: লাল রঙের ছোট বাটন (btn-danger) --}}
              <form action="{{ route('supplier.delete') }}" method="POST"
                onsubmit="return confirm('আপনি কি নিশ্চিত যে আপনি এই সরবরাহকারীকে ({{ $s->name }}) মুছে ফেলতে চান?');">
                @method('DELETE')
                @csrf
                <input type="hidden" name="supplier_id" value="{{ $s->id }}">
                <button type="submit" class="btn btn-sm btn-danger"
                  title="Delete Supplier: {{ $s->name }}">
                  <i class="fas fa-trash-alt"></i> {{-- Font Awesome Icon --}}
                </button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection