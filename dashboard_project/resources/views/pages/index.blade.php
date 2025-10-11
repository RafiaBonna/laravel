<!doctype html>
<body>
      <div class="container">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th> <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
             
             @foreach ($users as $single ) <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $single->name }}</td>
                <td>{{ $single->email }} </td> <td>
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
    </body>
</html>