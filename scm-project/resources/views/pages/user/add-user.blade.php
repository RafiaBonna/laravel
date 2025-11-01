@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Add New User</h2>

    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Role:</label>
            <select name="role_id" class="form-control" required>
                @foreach (\App\Models\Role::all() as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
