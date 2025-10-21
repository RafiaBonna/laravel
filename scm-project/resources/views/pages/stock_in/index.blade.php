@extends('layouts.master')

@section('content')
<h3>Stock In List</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Material</th>
            <th>Supplier</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Unit Price</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stockIns as $stock)
        <tr>
            <td>{{ $stock->id }}</td>
            <td>{{ $stock->rawMaterial->name }}</td>
            <td>{{ $stock->supplier->name }}</td>
            <td>{{ $stock->received_quantity }}</td>
            <td>{{ $stock->unit }}</td>
            <td>{{ $stock->unit_price ?? 'N/A' }}</td>
            <td>{{ $stock->received_date }}</td>
            <td>
                <a href="{{ route('stockin.invoice', $stock->id) }}" class="btn btn-info btn-sm">View Invoice</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
