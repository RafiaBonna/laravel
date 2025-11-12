{{-- resources/views/superadmin/products/create.blade.php (Final Layout - Cleaned) --}}

@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">➕ Add New Product</h3>
                    <div class="card-tools">
                        <a href="{{ route('superadmin.products.index') }}" class="btn btn-sm btn-dark">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('superadmin.products.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        
                        {{-- 🟢 Success Alert (এখন সবার উপরে) --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> **Success!** {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        {{-- 🔴 Global Validation Error Alert (এখন সবার উপরে) --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> **Data Save Failed!** Please check the input fields marked in red.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="row">
                            
                            {{-- LEFT COLUMN: Product Details & Financials (6 Col) --}}
                            <div class="col-md-6 border-right">
                                <h5 class="text-success mb-3">Product Details & Pricing</h5>

                                {{-- Product Name --}}
                                <div class="form-group">
                                    <label for="name">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" required>
                                    @error('name') 
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> 
                                    @enderror
                                </div>
                                
                                <div class="row">
                                    {{-- Product Code / SKU --}}
                                    <div class="col-md-6 form-group">
                                        <label for="sku">Product Code / SKU</label>
                                        <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" 
                                               value="{{ old('sku') }}">
                                        @error('sku') 
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> 
                                        @enderror
                                    </div>

                                    {{-- Unit --}}
                                    <div class="col-md-6 form-group">
                                        <label for="unit">Unit (e.g., Pcs, Box, Kg) <span class="text-danger">*</span></label>
                                        <input type="text" name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" 
                                               value="{{ old('unit', 'pcs') }}" required>
                                        @error('unit') 
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> 
                                        @enderror
                                    </div>
                                </div>

                                {{-- Financial Rates (Three fields in one row) --}}
                                <div class="row">
                                    {{-- MRP --}}
                                    <div class="col-md-4 form-group">
                                        <label for="mrp">MRP <span class="text-danger">*</span></label>
                                        <input type="number" name="mrp" id="mrp" class="form-control @error('mrp') is-invalid @enderror" 
                                               value="{{ old('mrp', 0.00) }}" step="any" min="0" required>
                                        @error('mrp') 
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> 
                                        @enderror
                                    </div>
                                    
                                    {{-- Retail Rate --}}
                                    <div class="col-md-4 form-group">
                                        <label for="retail_rate">Retail Rate</label>
                                        <input type="number" name="retail_rate" id="retail_rate" class="form-control @error('retail_rate') is-invalid @enderror" 
                                               value="{{ old('retail_rate', 0.00) }}" step="any" min="0">
                                        @error('retail_rate') 
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> 
                                        @enderror
                                    </div>

                                    {{-- Depo Selling Price --}}
                                    <div class="col-md-4 form-group">
                                        <label for="depo_selling_price">Depo Selling Price</label>
                                        <input type="number" name="depo_selling_price" id="depo_selling_price" class="form-control @error('depo_selling_price') is-invalid @enderror" 
                                               value="{{ old('depo_selling_price', 0.00) }}" step="any" min="0">
                                        @error('depo_selling_price') 
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> 
                                        @enderror
                                    </div>
                                </div>
                                
                                {{-- Description --}}
                                <div class="form-group">
                                    <label for="description">Description (Optional)</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                     @error('description') 
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> 
                                    @enderror
                                </div>

                            </div>

                            {{-- RIGHT COLUMN: System Information & Status (6 Col) - UPDATED --}}
                            <div class="col-md-6">
                                <h5 class="text-info mb-3">System Information & Status</h5>
                                
                                <div class="card bg-light shadow-none">
                                    <div class="card-body p-3">
                                        <h6 class="text-primary mb-3"><i class="fas fa-info-circle"></i> **Product Defaults**</h6>
                                        
                                        <table class="table table-sm table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td class="text-muted" style="width: 150px;">**Default Status**</td>
                                                    <td><span class="badge badge-success">Active</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">**Initial Stock**</td>
                                                    <td>0.00 Unit</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">**Stock Update**</td>
                                                    <td>Only via Product Receive</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="pt-3">
                                                        <small class="text-secondary">
                                                            *All newly created products are set to **Active** by default and require a **Product Receive** entry to update the initial stock quantity.
                                                        </small>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Save New Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection