@extends('master')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Add New Raw Material</h1>
            </div>
            <div class="col-sm-6 text-right">
                {{-- Back to Index Button --}}
                <a href="{{ route('raw_material.index') }}" class="btn btn-secondary">
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
                
                {{-- AdminLTE Card for the form --}}
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Material Details</h3>
                    </div>
                    
                    {{-- Form Start --}}
                    <form action="{{ route('raw_material.store') }}" method="POST">
                        @csrf
                        
                        <div class="card-body">
                            
                            {{-- 1. Name Field --}}
                            <div class="form-group">
                                <label for="name">Material Name</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    value="{{ old('name') }}" 
                                    placeholder="Enter material name (e.g., Cotton, Plastic Pellets)" 
                                    required
                                >
                                @error('name') 
                                    <span class="text-danger">{{ $message }}</span> 
                                @enderror
                            </div>
                            
                            {{-- 2. Unit Field --}}
                            <div class="form-group">
                                <label for="unit">Unit (e.g., pcs, kg, meter)</label>
                                <input 
                                    type="text" 
                                    name="unit" 
                                    id="unit" 
                                    class="form-control @error('unit') is-invalid @enderror" 
                                    value="{{ old('unit') }}" 
                                    placeholder="Enter unit of measurement" 
                                    required
                                >
                                @error('unit') 
                                    <span class="text-danger">{{ $message }}</span> 
                                @enderror
                            </div>
                            
                            {{-- 3. Alert Stock Field --}}
                            <div class="form-group">
                                <label for="alert_stock">Alert Stock Quantity</label>
                                <input 
                                    type="number" 
                                    name="alert_stock" 
                                    id="alert_stock" 
                                    class="form-control @error('alert_stock') is-invalid @enderror" 
                                    value="{{ old('alert_stock', 10) }}" 
                                    required 
                                    min="0"
                                >
                                @error('alert_stock') 
                                    <span class="text-danger">{{ $message }}</span> 
                                @enderror
                                <small class="form-text text-muted">A notification will be shown when the stock falls below this quantity.</small>
                            </div>
                            
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Save New Material
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