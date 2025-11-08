@extends('master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create New User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">User Details</h3>
                </div>
                
                <form action="{{ route('superadmin.users.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        
                        {{-- Basic User Details --}}
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Full Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required>
                                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Role and Status --}}
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="role_id">Role</label>
                                <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" data-slug="{{ $role->slug }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                            </div>
                        </div>

                        {{-- Dynamic Fields based on Role --}}
                        <div id="dynamic-fields">
                            {{-- 1. Depo Fields (role: depo) --}}
                            <div class="row depo-fields dynamic-field" style="display: none;">
                                <div class="col-12">
                                    <div class="alert alert-info">Fields for **Depo Manager** Role.</div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="location">Depo Location (Optional)</label>
                                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}">
                                    @error('location')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            
                            {{-- 2. Distributor Fields (role: distributor) --}}
                            <div class="row distributor-fields dynamic-field" style="display: none;">
                                <div class="col-12">
                                    <div class="alert alert-info">Fields for **Distributor** Role.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="distributor_depo_id">Assign to Depo</label>
                                    <select name="distributor_depo_id" class="form-control @error('distributor_depo_id') is-invalid @enderror">
                                        <option value="">Select Depo</option>
                                        @foreach ($depos as $depo)
                                            <option value="{{ $depo->id }}" {{ old('distributor_depo_id') == $depo->id ? 'selected' : '' }}>
                                                {{ $depo->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('distributor_depo_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="location">Location (Optional)</label>
                                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}">
                                    @error('location')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        
                        {{-- User Status --}}
                        <div class="form-group">
                            <label for="status">User Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_active" value="active" {{ old('status', 'active') == 'active' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_active">Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_inactive" value="inactive" {{ old('status') == 'inactive' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_inactive">Inactive</label>
                            </div>
                            @error('status')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create User</button>
                        <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Role পরিবর্তনের সময় ডাইনামিক ফিল্ড দেখানোর ফাংশন
            function toggleRoleFields() {
                var selectedRoleSlug = $('#role_id').find(':selected').data('slug');
                
                // প্রথমে সব ফিল্ড হাইড করুন
                $('.dynamic-field').hide();
                
                // রোল অনুযায়ী ফিল্ড দেখান
                if (selectedRoleSlug === 'depo') {
                    $('.depo-fields').show();
                } else if (selectedRoleSlug === 'distributor') {
                    $('.distributor-fields').show();
                }
            }
            
            // পেইজ লোড হওয়ার সময় এবং রোল পরিবর্তন হলে ফাংশনটি কল করুন
            toggleRoleFields();
            $('#role_id').change(toggleRoleFields);
        });
    </script>
@endsection