@extends('master')

@section('content')
<div class="card bg-primary-subtle p-5 w-100">
  <!-- Full-width background container -->
  <div class="bg-info-subtle p-5 rounded w-100 mt-5">

    <!-- Centered form inside full-width container -->
    <div class="d-flex justify-content-center">
      <form method="POST" action="{{ route('userStore') }}" class="w-100" style="max-width: 500px;">
        @csrf
        <h1 class="text-center mb-4">Add Users</h1>

        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">PASSWORD</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary form-control">Submit</button>
        </div>
      </form>
    </div>

  </div>
</div>
@endsection
