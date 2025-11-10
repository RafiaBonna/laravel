@extends('master')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Purchase Invoice: {{ $invoice->invoice_number }}</h6>
            <div>
                <a href="{{ route('superadmin.raw-material-purchases.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <button onclick="window.print()" class="btn btn-primary btn-sm">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
        <div class="card-body" id="invoice-body">
            
            {{-- INVOICE HEADER (Master Data) --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="font-weight-bold mb-1">Supplier Details:</p>
                    <p class="mb-0"><strong>Name:</strong> {{ $invoice->supplier->name ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Address:</strong> {{ $invoice->supplier->address ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Phone:</strong> {{ $invoice->supplier->phone ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <p class="font-weight-bold mb-1">Invoice Info:</p>
                    <p class="mb-0"><strong>Invoice No:</strong> <span class="text-danger">{{ $invoice->invoice_number }}</span></p>
                    <p class="mb-0"><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d F, Y') }}</p>
                    <p class="mb-0"><strong>Recorded By:</strong> {{ $invoice->user->name ?? 'N/A' }}</p>
                </div>
            </div>

            <hr>

            {{-- PURCHASE ITEMS TABLE --}}
            <h6 class="font-weight-bold text-primary">Purchased Items</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Material</th>
                            <th>Unit</th>
                            <th>Batch No.</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Unit Price</th>
                            <th class="text-right">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sl = 1; @endphp
                        @foreach($invoice->items as $item)
                        <tr>
                            <td>{{ $sl++ }}</td>
                            <td>{{ $item->rawMaterial->name ?? 'N/A' }}</td>
                            <td>{{ $item->rawMaterial->unit_of_measure ?? 'N/A' }}</td>
                            <td>{{ $item->batch_number }}</td>
                            <td class="text-right">{{ number_format($item->quantity, 2) }}</td>
                            <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-right font-weight-bold">{{ number_format($item->total_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- SUMMARY --}}
            <div class="row justify-content-end">
                <div class="col-md-5">
                    <table class="table table-sm table-borderless table-dark">
                        <tbody>
                            <tr>
                                <td class="font-weight-bold">Sub Total:</td>
                                <td class="text-right">{{ number_format($invoice->sub_total, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Discount:</td>
                                <td class="text-right text-danger">- {{ number_format($invoice->discount_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold h5">GRAND TOTAL:</td>
                                <td class="text-right font-weight-bold h5">BDT {{ number_format($invoice->grand_total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- NOTES --}}
            @if($invoice->notes)
            <div class="mt-4">
                <p class="font-weight-bold mb-1">Notes:</p>
                <p class="border p-2 bg-light">{{ $invoice->notes }}</p>
            </div>
            @endif

        </div>
    </div>
</div>

{{-- Printing CSS (Optional: Print করার সময় অপ্রয়োজনীয় অংশ লুকিয়ে রাখে) --}}
@push('styles')
<style>
    @media print {
        .main-sidebar, .main-header, .content-header, .btn, .card-header button {
            display: none !important;
        }
        .content-wrapper {
            margin-left: 0 !important;
        }
        .card-body {
            padding-top: 0 !important;
        }
    }
</style>
@endpush
@endsection