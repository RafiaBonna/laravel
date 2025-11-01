@extends('master')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Edit Distributor ({{ $user->name ?? 'N/A' }})</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Distributor Details</h3>
                        </div>
                        
                        <form action="{{ route('depo.users.update', $user->id ?? 1) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="card-body">
                                
                                {{-- Name Field --}}
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $user->name ?? '') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                {{-- Email Field --}}
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $user->email ?? '') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                
                                {{-- Current Depo (Read-only) --}}
                                <div class="form-group">
                                    <label for="current_depo">Assigned Depo</label>
                                    <input type="text" class="form-control" value="{{ $user->distributor->depo->name ?? 'N/A' }}" readonly>
                                </div>
                                
                                {{-- Password Field (Optional on Edit) --}}
                                <div class="form-group">
                                    <label for="password">New Password (Leave blank to keep current)</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                {{-- Password Confirmation Field --}}
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>

                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Distributor</button>
                                <a href="{{ route('depo.users.index') }}" class="btn btn-default float-right">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection