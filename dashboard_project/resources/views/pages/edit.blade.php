<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
       <div class="text-center">
        <p>Update User Details</p>
      </div>

      <div class="container">
        <form method="POST" action="{{ route('editStore') }}">
          @csrf
            <input type="text" name="user_id" hidden value="{{ $user->id }}"> 
            
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="name" class="form-control"  required value="{{ $user->name }}"> 
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label> 
                <input type="email" name="email" class="form-control"  required value="{{ $user->email }}"> 
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password (Leave blank to keep old password)</label> 
                <input type="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-H4v91GvF6mGqW1jB8y0vG5oF0aC3kFjKkG5i8l8l9mO7pI1sC5i9M7pA9oG6tQn5sK8" crossorigin="anonymous"></script>
    </body>
</html>