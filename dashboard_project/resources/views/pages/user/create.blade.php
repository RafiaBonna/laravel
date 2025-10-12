@extends('master')

@section('content')
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

 <title>Laravel CRUD</title>
  </head>
  <body>
      <div class="text-center">

        <p>Please Insert Users</p>

      </div>

      <div class="container">
        <form method="POST" action="{{ route('store') }}">
          @csrf
            <div class="mb-3">
              <label for="detailsa" class="form-label">Name</label>
              <input type="text" name="name" class="form-control"  required>

            </div>
            
            <div class="mb-3">
                <label for="detailsa" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required >

              </div>
              <div class="mb-3">
                <label for="detailsa" class="form-label">Password</label>
                <input type="text" name="password" class="form-control" required >

              </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
@endsection