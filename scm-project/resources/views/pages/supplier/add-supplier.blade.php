@extends('master')
@section('content')
<div class="card bg-primary-subtle p-5 w-100">
  <div class="bg-info-subtle p-5 rounded w-100 mt-5">
    <div class="d-flex justify-content-center">
      <form method="POST" action="{{ route('supplier.store') }}" class="w-100" style="max-width: 500px;">
        @csrf
        <h1 class="text-center mb-4">Add Supplier</h1>

        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Address</label>
          <input type="text" name="address" class="form-control" required>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary form-control">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
