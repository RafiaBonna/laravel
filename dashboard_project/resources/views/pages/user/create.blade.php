@extends('master')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="text-center mt-3">
            <h1>Create New User</h1>
        </div>

        <div class="container mt-5">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">User Details</h3>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-3 form-group">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>
                        
                        <div class="mb-3 form-group">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control" id="email" required >
                        </div>
                        
                        <div class="mb-3 form-group">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" name="password" class="form-control" id="password" required >
                        </div>
                        
                        <div class="mb-3 form-group">
                            <label for="role" class="form-label">Role:</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="depo" selected>Depo</option>
                                <option value="distributor">Distributor</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create User</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default float-right">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection