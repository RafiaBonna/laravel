@extends('master')
@section('content')
<div class="card bg-primary-subtle p-5 w-100">
  <div class="bg-info-subtle p-5 rounded w-100 mt-5">
    <div class="d-flex justify-content-center">
      <form method="POST" action="{{ route('supplier.update') }}" class="w-100" style="max-width: 500px;">
        @csrf
        <h1 class="text-center mb-4">Update Supplier</h1>

        <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">

        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" required value="{{ $supplier->name }}">
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required value="{{ $supplier->email }}">
        </div>

        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input type="text" name="phone" class="form-control" required value="{{ $supplier->phone }}">
        </div>

        <div class="mb-3">
          <label class="form-label">Address</label>
          <input type="text" name="address" class="form-control" required value="{{ $supplier->address }}">
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary form-control">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
