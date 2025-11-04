@extends('master')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Create New Distributor (Under Your Depo)</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Distributor Details</h3>
                        </div>
                        
                        {{-- ✅ CRITICAL FIX: সঠিক route('depo.users.store') এবং POST Method নিশ্চিত করা --}}
                        <form action="{{ route('depo.users.store') }}" method="POST"> 
                            @csrf {{-- ✅ CRITICAL FIX: CSRF টোকেন ছাড়া ডেটা সেভ হবে না (419 Error) --}}
                            
                            <div class="card-body">
                                
                                {{-- Name Field --}}
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                {{-- Email Field --}}
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                
                                {{-- Hidden Role Field: Controller-এ এই ফিল্ডের প্রয়োজন নেই, তবে সুরক্ষার জন্য রাখা যেতে পারে --}}
                                <input type="hidden" name="role" value="distributor"> 
                                
                                {{-- Password Field --}}
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                {{-- Password Confirmation Field --}}
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>

                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create Distributor</button>
                                <a href="{{ route('depo.users.index') }}" class="btn btn-default float-right">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection