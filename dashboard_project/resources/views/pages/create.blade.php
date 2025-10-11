<!doctype html>
<body>
      <div class="text-center">
        <p>Please Insert User Details</p>
      </div>

      <div class="container">
        <form method="POST" action="{{ route('store') }}">
          @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="name" class="form-control"  required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required >
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
      </div>
    </body>
</html>