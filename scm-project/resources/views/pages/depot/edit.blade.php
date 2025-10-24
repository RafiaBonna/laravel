@extends('master')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update Depot</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('depot.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                {{-- Validation Error Message --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        Please correct the following errors:
                    </div>
                @endif

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Edit Depot: **{{ $depot->name }}**</h3>
                    </div>
                    
                    {{-- Form Start --}}
                    <form action="{{ route('depot.update', $depot->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- For Update operation --}}
                        
                        <div class="card-body">
                            
                            {{-- Name Field (Required, Unique) --}}
                            <div class="form-group">
                                <label for="name">Depot Name</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    value="{{ old('name', $depot->name) }}" 
                                    required 
                                    autofocus
                                >
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            {{-- Address Field --}}
                            <div class="form-group">
                                <label for="address">Address (Optional)</label>
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $depot->address) }}</textarea>
                                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- Manager Name Field --}}
                            <div class="form-group">
                                <label for="manager_name">Manager Name (Optional)</label>
                                <input 
                                    type="text" 
                                    name="manager_name" 
                                    id="manager_name" 
                                    class="form-control @error('manager_name') is-invalid @enderror" 
                                    value="{{ old('manager_name', $depot->manager_name) }}"
                                >
                                @error('manager_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-save"></i> Update Depot
                            </button>
                        </div>
                    </form>
                    {{-- Form End --}}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection