{{-- resources/views/superadmin/sales/index.blade.php --}}

@extends('master') {{-- Use your main layout file name --}}

@section('title', 'Sales Invoice List')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sales Invoice List</h3>
                    <div class="card-tools">
                        <a href="{{ route('superadmin.sales.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create New Invoice
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Invoice No.</th>
                                <th>Depo</th>
                                <th>Created By</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                @php
                                    $rowClass = $invoice->status == 'Approved' ? 'table-success' : ($invoice->status == 'Canceled' ? 'table-danger' : '');
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td>{{ $invoice->invoice_no }}</td>
                                    <td>{{ $invoice->depo->name ?? 'N/A' }}</td>
                                    <td>{{ $invoice->creator->name ?? 'N/A' }}</td>
                                    <td>{{ $invoice->invoice_date }}</td>
                                    <td>{{ number_format($invoice->total_amount, 2) }} Taka</td>
                                    <td>
                                        <span class="badge badge-{{ $invoice->status == 'Pending' ? 'warning' : ($invoice->status == 'Approved' ? 'success' : 'danger') }}">
                                            {{ $invoice->status }}
                                        </span>
                                    </td>
                                    <td>
                                        {{-- Route for details (to be created later) --}}
                                        <a href="#" class="btn btn-info btn-sm">Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="mt-3">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection