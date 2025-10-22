@extends('master')

@section('content')
<h3>Stock Out List (Issued Materials)</h3>

{{-- Success/Error Message --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Material</th>
            <th>Destination (Depot)</th>
            <th>Quantity</th>
            <th>Unit</th>
            {{-- <th>Cost Price</th> --}}
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($stockOuts as $stock)
        <tr>
            <td>{{ $stock->id }}</td>
            <td>{{ $stock->rawMaterial->name }}</td>
            <td>{{ $stock->depot->name ?? 'N/A' }}</td> {{-- Depot নাম --}}
            <td>{{ $stock->issued_quantity }}</td>
            <td>{{ $stock->unit }}</td>
            {{-- <td>{{ $stock->cost_price ?? 'N/A' }}</td> --}}
            <td>{{ \Carbon\Carbon::parse($stock->issued_date)->format('d M Y') }}</td>
            <td>
                {{-- View Invoice Button --}}
                <a href="{{ route('stockout.invoice', $stock->id) }}" class="btn btn-info btn-sm">View Invoice</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">No issued materials found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection