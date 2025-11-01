@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Edit User: {{ $user->name }}</h2>

    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Role:</label>
            <select name="role_id" class="form-control" required>
                @foreach (\App\Models\Role::all() as $role)
                    <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Password (Leave blank to keep current):</label>
            <input type="password" name="password" class="form-control" placeholder="New Password">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
