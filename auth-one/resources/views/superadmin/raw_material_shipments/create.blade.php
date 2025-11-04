@extends('master')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Record Raw Material Shipment (Transfer Out)</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card card-danger">
                        <div class="card-header"><h3 class="card-title">Shipment Details (Stock Out)</h3></div>
                        
                        <form action="{{ route('superadmin.raw_material_shipments.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="shipment_date">Shipment Date <span class="text-danger">*</span></label>
                                            <input type="date" name="shipment_date" class="form-control @error('shipment_date') is-invalid @enderror" value="{{ old('shipment_date', date('Y-m-d')) }}" required>
                                            @error('shipment_date') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="depo_id">Destination Depo <span class="text-danger">*</span></label>
                                            <select name="depo_id" class="form-control @error('depo_id') is-invalid @enderror" required>
                                                <option value="">-- Select Depo --</option>
                                                @foreach ($depos as $depo)
                                                    <option value="{{ $depo->id }}" {{ old('depo_id') == $depo->id ? 'selected' : '' }}>{{ $depo->name }} ({{ $depo->location }})</option>
                                                @endforeach
                                            </select>
                                            @error('depo_id') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="raw_material_id">Raw Material <span class="text-danger">*</span></label>
                                    <select name="raw_material_id" id="raw_material_id" class="form-control @error('raw_material_id') is-invalid @enderror" required>
                                        <option value="">-- Select Raw Material --</option>
                                        @foreach ($rawMaterials as $material)
                                            <option 
                                                value="{{ $material->id }}" 
                                                data-unit="{{ $material->unit }}"
                                                data-stock="{{ $material->current_stock }}"
                                                {{ old('raw_material_id') == $material->id ? 'selected' : '' }}
                                            >
                                                {{ $material->name }} (Stock: {{ number_format($material->current_stock, 2) }} {{ $material->unit }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('raw_material_id') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                    <small class="form-text text-info mt-2" id="stock-info">Current Stock: 0 Unit</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="quantity">Quantity to Ship <span class="text-danger">*</span></label>
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
                                            <label for="driver_name">Driver Name (Optional)</label>
                                            <input type="text" name="driver_name" class="form-control @error('driver_name') is-invalid @enderror" value="{{ old('driver_name') }}">
                                            @error('driver_name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger">Record Stock Out & Ship</button>
                                <a href="{{ route('superadmin.raw_material_shipments.index') }}" class="btn btn-default float-right">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        // Quantity Field-এ Material Unit এবং Stock Info দেখানো
        document.addEventListener('DOMContentLoaded', function () {
            const rawMaterialSelect = document.getElementById('raw_material_id');
            const unitSpan = document.getElementById('material-unit');
            const stockInfo = document.getElementById('stock-info');

            function updateInfo() {
                const selectedOption = rawMaterialSelect.options[rawMaterialSelect.selectedIndex];
                const unit = selectedOption.getAttribute('data-unit') || 'Unit';
                const stock = selectedOption.getAttribute('data-stock') || '0';
                
                unitSpan.textContent = unit;
                stockInfo.textContent = 'Current Stock: ' + parseFloat(stock).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' ' + unit;
            }

            rawMaterialSelect.addEventListener('change', updateInfo);
            updateInfo(); // Initial call to set the info on load
        });
    </script>

@endsection
