@extends('master') {{-- Your main layout file (master.blade.php) --}}

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit User ({{ ucfirst($user->role) }}: {{ $user->name }})</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update User Details</h3>
                        </div>
                        
                        {{-- Target: Superadmin\UserController.php update() method --}}
                        <form action="{{ route('superadmin.users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT') {{-- Required for Update requests in Laravel --}}
                            
                            <div class="card-body">
                                
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" 
                                           value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" 
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="role">User Role</label>
                                    <select name="role" class="form-control @error('role') is-invalid @enderror" id="role" required>
                                        <option value="">Select Role</option>
                                        <option value="depo" {{ old('role', $user->role) == 'depo' ? 'selected' : '' }}>Depo</option>
                                        <option value="distributor" {{ old('role', $user->role) == 'distributor' ? 'selected' : '' }}>Distributor</option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Password (Leave blank to keep current password)</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                                </div>

                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update User</button>
                                <a href="{{ route('superadmin.users.index') }}" class="btn btn-default float-right">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection