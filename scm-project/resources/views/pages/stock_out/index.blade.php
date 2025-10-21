@extends('master')

@section('content')
<h3>Stock Out List</h3>

{{-- Success Handling --}}
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Material</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Issued By</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stockOuts as $stock)
        <tr>
            <td>{{ $stock->id }}</td>
            <td>{{ $stock->rawMaterial->name ?? 'N/A' }}</td>
            <td>{{ number_format($stock->issued_quantity, 2) }}</td>
            <td>{{ $stock->unit ?? 'N/A' }}</td>
            <td>{{ $stock->issuer->name ?? 'User Deleted' }}</td>
            <td>{{ \Carbon\Carbon::parse($stock->issue_date)->format('d M Y') }}</td>
            <td>
                {{-- ⭐ Invoice Button ⭐ --}}
                <a href="{{ route('stockout.invoice', $stock->id) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-file-invoice"></i> View Invoice
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection