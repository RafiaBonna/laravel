<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
       <div class="text-center">
        <h1>User List</h1>

        <br>
        <a href="{{ route('create') }}">
          <button class="btn btn-md btn-success">Add User</button>
        </a>


      </div>
      <br>

      <div class="container">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th> 
                <th scope="col">Password</th> 
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
             
             @foreach ($users as $single ) <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $single->name }}</td>
                <td>{{ $single->email }} </td> 
                <td>{{ $single->password }} </td> 
                <td>
                    <div class="btn-group">
                      <a href="{{ route('edit', $single->id) }}">
                        <button class="btn btn-md btn-success me-1 p-1">edit</button>
                      </a>

                    <form action="{{route('delete')}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <input type="text" name="user_id" value="{{ $single->id }}" hidden>
                      <button class="btn btn-md btn-danger  p-1">delete</button>
                </form>
                    </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-H4v91GvF6mGqW1jB8y0vG5oF0aC3kFjKkG5i8l8l9mO7pI1sC5i9M7pA9oG6tQn5sK8" crossorigin="anonymous"></script>
    </body>
</html>