@extends('master')

@section('content')
<h3>Receive Raw Material</h3>

<form action="{{ route('stockin.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Raw Material</label>
        <select name="raw_material_id" class="form-control" required>
            <option value="">Select Material</option>
            @foreach($rawMaterials as $material)
                {{-- ✅ RE-ADDED: Stock display --}}
                <option value="{{ $material->id }}">{{ $material->name }} (Stock: {{ $material->current_stock }})</option> 
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Supplier</label>
        <select name="supplier_id" class="form-control" required>
            <option value="">Select Supplier</option>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Received Quantity</label>
        <input type="number" step="0.01" name="received_quantity" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Unit Price</label>
        <input type="number" step="0.01" name="unit_price" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Receive</button>
</form>
@endsection