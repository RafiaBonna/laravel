@extends('master') 

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Raw Material Receivings (Stock In)</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Stock In Invoices List</h3>
                    <div class="card-tools">
                        <a href="{{ route('superadmin.raw_material_receivings.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Record New Receiving
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Invoice No.</th>
                                <th>Date</th>
                                <th>Raw Material</th>
                                <th>Supplier</th>
                                <th>Quantity</th>
                                <th>Total Cost</th>
                                <th>Recorded By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($receivings as $receiving)
                                <tr>
                                    <td>{{ $receiving->invoice_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($receiving->receiving_date)->format('d M, Y') }}</td>
                                    <td>{{ $receiving->rawMaterial->name ?? 'N/A' }}</td>
                                    <td>{{ $receiving->supplier->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($receiving->quantity, 2) }} {{ $receiving->rawMaterial->unit ?? '' }}</td>
                                    <td>{{ number_format($receiving->quantity * $receiving->unit_cost, 2) }} BDT</td>
                                    <td>{{ $receiving->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.raw_material_receivings.show', $receiving->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View Invoice
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No Raw Material Receivings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection