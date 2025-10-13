<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Category</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h2 class="mb-4">Edit Category</h2>

  <form action="{{ route('category.update', $cat->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Brand</label>
      <input type="text" name="brand" class="form-control" value="{{ $cat->brand }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Value</label>
      <input type="text" name="value" class="form-control" value="{{ $cat->value }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="3">{{ $cat->detail->description ?? '' }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('category.index') }}" class="btn btn-secondary">Back</a>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
