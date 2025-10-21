@extends('master')

@section('content')
<h3>Issue Raw Material (Stock Out)</h3>

{{-- Error Handling --}}
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('stockout.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label>Raw Material</label>
        <select name="raw_material_id" class="form-control @error('raw_material_id') is-invalid @enderror" required>
            <option value="">Select Material</option>
            @foreach($rawMaterials as $material)
                <option value="{{ $material->id }}" {{ old('raw_material_id') == $material->id ? 'selected' : '' }}>
                    {{ $material->name }} (Stock: {{ number_format($material->current_stock, 2) }} {{ $material->unit }})
                </option>
            @endforeach
        </select>
        @error('raw_material_id') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Issued To (User/Recipient)</label>
        <select name="issued_by_user_id" class="form-control @error('issued_by_user_id') is-invalid @enderror" required>
            <option value="">Select Recipient</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('issued_by_user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('issued_by_user_id') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    
    <div class="form-group">
        <label>Quantity to Issue</label>
        <input type="number" step="0.01" name="issued_quantity" class="form-control @error('issued_quantity') is-invalid @enderror" value="{{ old('issued_quantity') }}" required min="0.01">
        @error('issued_quantity') <span class="text-danger">{{ $message }}</span> @enderror
        <small class="form-text text-muted">Stock will be decreased by this amount.</small>
    </div>
    
    <div class="form-group">
        <label>Purpose/Remarks (Optional)</label>
        <input type="text" name="purpose" class="form-control @error('purpose') is-invalid @enderror" value="{{ old('purpose') }}">
        @error('purpose') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="btn btn-danger">Issue Stock Out</button>
</form>
@endsection