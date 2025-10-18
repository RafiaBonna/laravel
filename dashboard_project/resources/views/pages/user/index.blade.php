@extends('master')

@section('content')
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
       <div class="text-center">
        <h1>User List</h1>

        <br>
        {{-- CREATE রুটটি নতুন অ্যাডমিন রুট ব্যবহার করে ঠিক করা হলো --}}
        <a href="{{ route('admin.users.create') }}">
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
                {{-- Role দেখানোর জন্য নতুন কলাম যোগ করা হলো --}}
                <th scope="col">Role</th> 
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
             
             @foreach ($users as $single ) <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $single->name }}</td>
                <td>{{ $single->email }} </td> 
                {{-- Role ডেটা প্রদর্শন করা হলো --}}
                <td>{{ $single->role }} </td>
                <td>
                    <div class="btn-group">
                      {{-- EDIT রুটটি নতুন অ্যাডমিন রুট ব্যবহার করে ঠিক করা হলো --}}
                      <a href="{{ route('admin.users.edit', $single->id) }}">
                        <button class="btn btn-md btn-success me-1 p-1">edit</button>
                      </a>

                    {{-- DELETE রুটটি নতুন অ্যাডমিন রুট ব্যবহার করে ঠিক করা হলো --}}
                    <form action="{{route('admin.users.delete')}}" method="POST">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-H4v91GvF6mGqW1jB8y0vG5oF0aC3kFjKkG5i8l8l9mO7pI1sC5i9M7pA9oG6tQn5..." crossorigin="anonymous"></script>
    @endsection
