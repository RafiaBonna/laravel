<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Category List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h1 class="text-center mb-4">Category List</h1>

  @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
  @endif
  @if(session('danger'))
    <div class="alert alert-danger text-center">{{ session('danger') }}</div>
  @endif

  <div class="text-center mb-3">
    <a href="{{ route('category.create') }}" class="btn btn-success">Add Category</a>
  </div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Brand</th>
        <th>Value</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($cats as $single)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $single->name }}</td>
          <td>{{ $single->brand }}</td>
          <td>{{ $single->value }}</td>
          <td>{{ $single->detail->description ?? '-' }}</td>
          <td>
            <a href="{{ route('category.edit', $single->id) }}" class="btn btn-success btn-sm">Edit</a>
            <form action="{{ route('category.delete') }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <input type="hidden" name="catagory_id" value="{{ $single->id }}">
              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
