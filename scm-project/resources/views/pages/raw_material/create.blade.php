@extends('master')
@section('content')

{{-- Content Header (Page header) --}}
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

{{-- Main content --}}
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            {{-- Screenshot-er moto centralize korte col-md-6 byabohar kora holo --}}
            <div class="col-md-6">
                
                {{-- Validation Error Message --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                {{-- AdminLTE Card for the form --}}
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Material Entry Form</h3>
                    </div>
                    
                    {{-- Form Start --}}
                    <form action="{{ route('raw_material.store') }}" method="POST">
                        @csrf
                        
                        <div class="card-body">
                            
                            {{-- 1. Material Name Field --}}
                            <div class="form-group">
                                <label for="name">Material Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    value="{{ old('name') }}" 
                                    placeholder="Enter material name" 
                                    required
                                >
                                @error('name') 
                                    <span class="text-danger text-sm">{{ $message }}</span> 
                                @enderror
                            </div>

                            {{-- 2. Unit Field --}}
                            <div class="form-group">
                                <label for="unit">Unit of Measure <span class="text-danger">*</span></label>
                                <select 
                                    name="unit" 
                                    id="unit" 
                                    class="form-control @error('unit') is-invalid @enderror" 
                                    required
                                >
                                    <option value="">Select Unit</option>
                                    <option value="PCS" {{ old('unit') == 'PCS' ? 'selected' : '' }}>PCS (Pieces)</option>
                                    <option value="KG" {{ old('unit') == 'KG' ? 'selected' : '' }}>KG (Kilogram)</option>
                                    <option value="LTR" {{ old('unit') == 'LTR' ? 'selected' : '' }}>LTR (Liter)</option>
                                    <option value="MTR" {{ old('unit') == 'MTR' ? 'selected' : '' }}>MTR (Meter)</option>
                                    <option value="BOX" {{ old('unit') == 'BOX' ? 'selected' : '' }}>BOX</option>
                                </select>
                                @error('unit') 
                                    <span class="text-danger text-sm">{{ $message }}</span> 
                                @enderror
                            </div>

                            {{-- 3. Alert Stock Quantity Field --}}
                            <div class="form-group">
                                <label for="alert_stock">Alert Stock Quantity <span class="text-danger">*</span></label>
                                <input 
                                    type="number" 
                                    name="alert_stock" 
                                    id="alert_stock" 
                                    class="form-control @error('alert_stock') is-invalid @enderror" 
                                    value="{{ old('alert_stock', 10) }}" 
                                    required 
                                    min="0"
                                    step="0.01"
                                >
                                @error('alert_stock') 
                                    <span class="text-danger text-sm">{{ $message }}</span> 
                                @enderror
                                <small class="form-text text-muted">Set the minimum stock level for alert notifications.</small>
                            </div>
                            
                            {{-- 4. Current Stock (Read-only for info) --}}
                            <div class="form-group">
                                <label>Initial Current Stock</label>
                                <input type="text" class="form-control bg-light" value="0.00" disabled>
                                <small class="form-text text-muted">Stock will be updated in the **Product Received** section.</small>
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