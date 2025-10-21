@extends('master')
@section('content')

{{-- ... (header part) ... --}}

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Edit Material: **{{ $material->name }}**</h3>
                    </div>
                    
                    <form action="{{ route('raw_material.update', $material->id) }}" method="POST">
                        @csrf
                        @method('PUT') 
                        
                        <div class="card-body">
                            
                            {{-- Name Field --}}
                            <div class="form-group">
                                <label for="name">Material Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $material->name) }}" required autofocus>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- Unit Field --}}
                            <div class="form-group">
                                <label for="unit">Unit of Measure (e.g., pcs, kg, meter)</label>
                                <input type="text" name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit', $material->unit) }}" required>
                                @error('unit') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            {{-- Alert Stock Field --}}
                            <div class="form-group">
                                <label for="alert_stock">Alert Stock Quantity</label>
                                <input type="number" name="alert_stock" id="alert_stock" class="form-control @error('alert_stock') is-invalid @enderror" value="{{ old('alert_stock', $material->alert_stock) }}" required min="0">
                                @error('alert_stock') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- ✅ ADDED: Current Stock (Read-only for info) --}}
                            <div class="form-group">
                                <label>Current Stock</label>
                                <input type="text" class="form-control bg-light" value="{{ number_format($material->current_stock, 2) }} {{ $material->unit }}" disabled>
                                <small class="form-text text-muted">Current stock is updated automatically via the "Stock In" and "Stock Out" sections.</small>
                            </div>
                            
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-save"></i> Update Material
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection