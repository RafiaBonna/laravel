@extends('master')
@section('content')

{{-- ... (header and content setup) ... --}}

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                {{-- ... (error handling) ... --}}
                
                <div class="card card-primary">
                    {{-- ... (card-header) ... --}}
                    
                    <form action="{{ route('raw_material.store') }}" method="POST">
                        @csrf
                        
                        <div class="card-body">
                            
                            {{-- Name Field --}}
                            <div class="form-group">
                                <label for="name">Material Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            {{-- Unit Field --}}
                            <div class="form-group">
                                <label for="unit">Unit of Measure (e.g., pcs, kg, meter)</label>
                                <input type="text" name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit', 'pcs') }}" required maxlength="50">
                                @error('unit') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            {{-- Alert Stock Field --}}
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
                </div>
            </div>
        </div>
    </div>
</section>

@endsection