// File: resources/views/pages/user/index.blade.php

@extends('master')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="text-center mt-3">
            <h1>User List</h1>
            <br>
            <a href="{{ route('create') }}">
              <button class="btn btn-md btn-success">Add User</button>
            </a>
        </div>
        <br>

        <div class="container">
            <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th> 
                    <th scope="col">Role</th> <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                 
                 @foreach ($users as $single ) 
                 <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $single->name }}</td>
                    <td>{{ $single->email }} </td> 
                    <td>{{ ucfirst($single->role) }} </td> <td>
                        <div class="btn-group">
                          <a href="{{ route('edit', $single->id) }}">
                            <button class="btn btn-sm btn-success me-1 p-1">Edit</button>
                          </a>

                        <form action="{{route('delete')}}" method="POST" style="display:inline-block;">
                            @method('DELETE')
                            @csrf
                            <input type="text" name="user_id" value="{{ $single->id }}" hidden>
                          <button class="btn btn-sm btn-danger p-1" type="submit" onclick="return confirm('আপনি কি এই ইউজারটি নিশ্চিতভাবে ডিলিট করতে চান?');">Delete</button>
                        </form>
                        </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection