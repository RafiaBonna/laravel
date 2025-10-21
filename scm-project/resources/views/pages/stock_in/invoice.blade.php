@extends('layouts.master')

@section('content')
<h3>Invoice #{{ $stock->id }}</h3>

<p><strong>Material:</strong> {{ $stock->rawMaterial->name }}</p>
<p><strong>Supplier:</strong> {{ $stock->supplier->name }}</p>
<p><strong>Quantity:</strong> {{ $stock->received_quantity }} {{ $stock->unit }}</p>
<p><strong>Unit Price:</strong> {{ $stock->unit_price ?? 'N/A' }}</p>
<p><strong>Date:</strong> {{ $stock->received_date }}</p>
@endsection
