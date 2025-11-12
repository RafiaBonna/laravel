{{-- resources/views/superadmin/products/edit.blade.php --}}

@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">✍️ Edit Product: {{ $product->name }}</h3>
                </div>
                <form action="{{ route('superadmin.products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $product->name) }}" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" 
                                       value="{{ old('sku', $product->sku) }}">
                                @error('sku') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="unit">Unit (e.g., Pcs, Box, Kg) <span class="text-danger">*</span></label>
                                <input type="text" name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" 
                                       value="{{ old('unit', $product->unit) }}" required>
                                @error('unit') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="is_active">Status</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1" {{ old('is_active', $product->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $product->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Description (Optional)</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-warning btn-lg">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection