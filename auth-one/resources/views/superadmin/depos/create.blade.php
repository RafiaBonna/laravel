@extends('master') {{-- Change this according to your master layout file --}}

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Add New Depo</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-indigo">
                        <div class="card-header"><h3 class="card-title">Depo Details</h3></div>
                        
                        <form action="{{ route('superadmin.depos.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                
                                {{-- Success/Error Message --}}
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <div class="form-group">
                                    <label for="name">Depo Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g., Dhaka Depo" required>
                                    @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="location">Location / Address <span class="text-danger">*</span></label>
                                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" placeholder="e.g., Tejgaon Industrial Area, Dhaka" required>
                                    @error('location') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                
                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-indigo">Create Depo</button>
                                <a href="{{ route('superadmin.depos.index') }}" class="btn btn-default float-right">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
