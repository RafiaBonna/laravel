@extends('master')

@section('content')
  <div class="card">
    <div class="header pb-5 pt-5 pt-lg-8 d-flex align-items-center"
      style="min-height: 50px; background-image: url(../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
      <span class="mask bg-gradient-default opacity-8"></span>
      <div class="container-fluid d-flex align-items-center">
        <div class="row align-items-center">
          <div class="col-lg-12 col-md-10 text-center">
            <h1 class="display-2 text-white text-center"> Users List</h1>
            <a href="{{ route('userCreate') }}" class="btn btn-dark">Add Users</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div>
    <div class="table-responsive"> {{-- টেবিলকে রেসপনসিভ করা হলো --}}
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Password</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $u)
            <tr>
              <th scope="row">{{ $loop->iteration }}</th>
              <td>{{ $u->name }}</td>
              <td>{{ $u->email }}</td>
              <td>{{ $u->password }}</td>
              <td>
                {{-- ✅ FIXED: d-flex ব্যবহার করে বাটনগুলির বিন্যাস ঠিক করা হলো --}}
                <div class="d-flex">
                  {{-- 1. Edit Button --}}
                  {{-- <a> ট্যাগকেই বাটন হিসেবে ব্যবহার করা হলো, এবং me-1 দিয়ে spacing যোগ করা হলো --}}
                  <a href="{{ route('userEdit', $u->id) }}" 
                     class="btn btn-sm btn-success p-1 me-1" 
                     title="Edit User">
                    <i class="bi bi-pencil-square"></i>
                  </a>

                  {{-- 2. Delete Button --}}
                  {{-- ✅ FIXED: onsubmit এ JavaScript confirm যোগ করা হলো --}}
                  <form action="{{ route('delete') }}" method="POST"
                    onsubmit="return confirm('আপনি কি নিশ্চিত যে আপনি এই ব্যবহারকারীকে ({{ $u->name }}) মুছে ফেলতে চান?');">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $u->id }}">
                    <button type="submit" class="btn btn-sm btn-danger p-1" title="Delete User">
                      <i class="bi bi-trash3-fill"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection