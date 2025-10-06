@extends('master')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h3 class="card-title text-center mb-4">Registration Form</h3>
          <form>
            <div class="mb-3">
              <label for="inputName" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="inputName" placeholder="Enter your full name" required>
            </div>
            <div class="mb-3">
              <label for="inputEmail" class="form-label">Email address</label>
              <input type="email" class="form-control" id="inputEmail" placeholder="name@example.com" required>
            </div>
            <div class="mb-3">
              <label for="inputPassword" class="form-label">Password</label>
              <input type="password" class="form-control" id="inputPassword" placeholder="Password" required>
            </div>
            <div class="mb-3">
              <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="inputConfirmPassword" placeholder="Confirm Password" required>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="termsCheck">
              <label class="form-check-label" for="termsCheck">I agree to the <a href="#">terms and conditions</a></label>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Register</button>
              <button type="reset" class="btn btn-outline-secondary">Clear Form</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
@endsection