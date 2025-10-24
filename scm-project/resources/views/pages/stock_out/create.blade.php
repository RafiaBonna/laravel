@extends('master')

@section('content')
<h3>Issue Raw Material</h3>

{{-- Error/Success Messages --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">Please fix the following errors.</div>
@endif


<form action="{{ route('stockout.store') }}" method="POST">
    @csrf
    
    {{-- Raw Material Select Field --}}
    <div class="form-group">
        <label>Raw Material</label>
        <select name="raw_material_id" class="form-control @error('raw_material_id') is-invalid @enderror" required>
            <option value="">Select Material</option>
            @foreach($rawMaterials as $material)
                <option value="{{ $material->id }}" {{ old('raw_material_id') == $material->id ? 'selected' : '' }}>
                    {{ $material->name }} (Stock: {{ $material->current_stock }} {{ $material->unit }})
                </option>
            @endforeach
        </select>
        @error('raw_material_id') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    {{-- Depot/Destination Select Field (Suppliers-এর জায়গায় Depot) --}}
    <div class="form-group">
        <label>Destination Depot</label>
        <select name="depot_id" class="form-control @error('depot_id') is-invalid @enderror" required>
            <option value="">Select Depot</option>
            @foreach($depots as $depot)
                <option value="{{ $depot->id }}" {{ old('depot_id') == $depot->id ? 'selected' : '' }}>
                    {{ $depot->name }}
                </option>
            @endforeach
        </select>
        @error('depot_id') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    {{-- Issued Quantity Field --}}
    <div class="form-group">
        <label>Issued Quantity</label>
        <input type="number" step="0.01" name="issued_quantity" class="form-control @error('issued_quantity') is-invalid @enderror" value="{{ old('issued_quantity') }}" required min="0.01">
        @error('issued_quantity') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    {{-- Unit Price (ঐচ্ছিক, Stock In এ না থাকায় এখানেও বাদ দেওয়া হলো) --}}
    {{-- <div class="form-group">
        <label>Cost Price</label>
        <input type="number" step="0.01" name="cost_price" class="form-control" value="{{ old('cost_price') }}">
    </div> --}}

    <button type="submit" class="btn btn-danger">Issue Material</button>
</form>
@endsection