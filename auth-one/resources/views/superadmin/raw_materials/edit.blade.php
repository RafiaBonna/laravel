@extends('master')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Edit Raw Material: {{ $rawMaterial->name }}</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Material Details</h3>
                        </div>
                        
                        <form action="{{ route('superadmin.raw_materials.update', $rawMaterial->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="card-body">
                                
                                <div class="form-group">
                                    <label for="name">Material Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $rawMaterial->name) }}" required>
                                    @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="unit">Unit of Measure <span class="text-danger">*</span></label>
                                    <select name="unit" class="form-control @error('unit') is-invalid @enderror" required>
                                        <option value="">-- Select Unit --</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit }}" {{ old('unit', $rawMaterial->unit) == $unit ? 'selected' : '' }}>{{ ucfirst($unit) }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="current_stock">Current Stock (Read Only)</label>
                                    <input type="text" class="form-control" value="{{ number_format($rawMaterial->current_stock, 2) }} {{ $rawMaterial->unit }}" readonly>
                                    <small class="form-text text-danger">Stock can only be changed via **Stock In** and **Stock Out** processes.</small>
                                </div>

                                <div class="form-group">
                                    <label for="alert_stock">Alert Stock Level <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="alert_stock" class="form-control @error('alert_stock') is-invalid @enderror" value="{{ old('alert_stock', $rawMaterial->alert_stock) }}" required>
                                    <small class="form-text text-muted">A notification will be triggered when stock falls below this level.</small>
                                    @error('alert_stock') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>

                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Material</button>
                                <a href="{{ route('superadmin.raw_materials.index') }}" class="btn btn-default float-right">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection