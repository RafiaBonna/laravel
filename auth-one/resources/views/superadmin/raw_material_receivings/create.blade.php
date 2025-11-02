@extends('master')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Record Raw Material Receiving (Stock In)</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            {{-- ✅ কলামের আকার বাড়ানো হয়েছে: col-md-10 এবং offset-md-1 --}}
            <div class="row">
                <div class="col-md-10 offset-md-1"> 
                    <div class="card card-primary">
                        <div class="card-header"><h3 class="card-title">Receiving Details</h3></div>
                        
                        <form action="{{ route('superadmin.raw_material_receivings.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                
                                {{-- Receiving Date এবং Invoice Number-কে পাশাপাশি রাখা হলো --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="receiving_date">Receiving Date <span class="text-danger">*</span></label>
                                            <input type="date" name="receiving_date" class="form-control @error('receiving_date') is-invalid @enderror" value="{{ old('receiving_date', date('Y-m-d')) }}" required>
                                            @error('receiving_date') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="invoice_number">Invoice Number <span class="text-danger">*</span></label>
                                            <input type="text" name="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" value="{{ old('invoice_number') }}" required>
                                            @error('invoice_number') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                                    <select name="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror" required>
                                        <option value="">-- Select Supplier --</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="raw_material_id">Raw Material <span class="text-danger">*</span></label>
                                    <select name="raw_material_id" class="form-control @error('raw_material_id') is-invalid @enderror" required>
                                        <option value="">-- Select Raw Material --</option>
                                        @foreach ($rawMaterials as $material)
                                            <option value="{{ $material->id }}" data-unit="{{ $material->unit }}" {{ old('raw_material_id') == $material->id ? 'selected' : '' }}>{{ $material->name }} (Unit: {{ $material->unit }})</option>
                                        @endforeach
                                    </select>
                                    @error('raw_material_id') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>

                                {{-- Quantity এবং Unit Cost-কে পাশাপাশি রাখা হলো --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" required min="0.01">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="material-unit">Unit</span>
                                                </div>
                                            </div>
                                            @error('quantity') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="unit_cost">Unit Cost (Per Unit) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="unit_cost" class="form-control @error('unit_cost') is-invalid @enderror" value="{{ old('unit_cost', 0) }}" required min="0">
                                            @error('unit_cost') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            {{-- সেভ বাটন --}}
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Record Stock In</button>
                                <a href="{{ route('superadmin.raw_material_receivings.index') }}" class="btn btn-default float-right">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        // Raw Material সিলেক্ট করার পর Quantity Field-এ Material Unit (kg/pc/m) দেখানো
        document.addEventListener('DOMContentLoaded', function () {
            const rawMaterialSelect = document.querySelector('select[name="raw_material_id"]');
            const unitSpan = document.getElementById('material-unit');

            function updateUnit() {
                const selectedOption = rawMaterialSelect.options[rawMaterialSelect.selectedIndex];
                const unit = selectedOption.getAttribute('data-unit') || 'Unit';
                unitSpan.textContent = unit;
            }

            rawMaterialSelect.addEventListener('change', updateUnit);
            updateUnit(); // Initial call to set the unit on load
        });
    </script>

@endsection