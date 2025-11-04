@extends('master')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Raw Material Receive Invoice</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body p-4">
                    
                    {{-- HEADER SECTION --}}
                    <div class="row mb-4 border-bottom pb-3">
                        <div class="col-md-6">
                            <h4><i class="fas fa-file-invoice"></i> Raw Material Receive Invoice</h4>
                            <p class="mb-1"><strong>From Supplier:</strong> {{ $receiving->supplier->name ?? 'N/A' }}</p>
                            <p class="mb-1">Supplier ID: #{{ $receiving->supplier->id ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="col-md-6 text-right">
                            <p class="mb-1"><strong>Invoice ID:</strong> #{{ $receiving->invoice_number }}</p>
                            <p class="mb-1"><strong>Date:</strong> {{ \Carbon\Carbon::parse($receiving->created_at)->format('d M Y') }}</p>
                            <p class="mb-1"><strong>Received Date:</strong> {{ \Carbon\Carbon::parse($receiving->receiving_date)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    
                    {{-- ITEM DETAIL TABLE --}}
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="bg-light">
                                    <th>Material Name</th>
                                    <th>Unit</th>
                                    <th class="text-right">Quantity</th>
                                    <th class="text-right">Unit Price (TK)</th>
                                    <th class="text-right">Subtotal (TK)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $receiving->rawMaterial->name ?? 'N/A' }}</td>
                                    <td>{{ $receiving->rawMaterial->unit ?? 'N/A' }}</td>
                                    <td class="text-right">{{ number_format($receiving->quantity, 2) }}</td>
                                    <td class="text-right">{{ number_format($receiving->unit_cost, 2) }}</td>
                                    <td class="text-right">{{ number_format($receiving->quantity * $receiving->unit_cost, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- NOTES AND TOTALS --}}
                    <div class="row">
                        <div class="col-md-7">
                            <p class="font-weight-bold">Notes:</p>
                            <blockquote class="blockquote border-left-info pl-2">
                                <p class="mb-0 small">Raw material received and successfully added to inventory by {{ $receiving->user->name ?? 'N/A' }}.</p>
                            </blockquote>
                        </div>
                        
                        <div class="col-md-5">
                            @php
                                $subtotal = $receiving->quantity * $receiving->unit_cost;
                                // এখানে ট্যাক্স/ডিসকাউন্ট এর লজিক যুক্ত করা যেতে পারে, কিন্তু আপাতত 0 ধরা হলো।
                                $tax = 0.00; 
                                $total = $subtotal + $tax;
                            @endphp
                            <table class="table table-sm float-right" style="width: 100%;">
                                <tr>
                                    <th>Subtotal:</th>
                                    <td class="text-right">{{ number_format($subtotal, 2) }} TK</td>
                                </tr>
                                <tr>
                                    <th>Tax (0%):</th>
                                    <td class="text-right">{{ number_format($tax, 2) }} TK</td>
                                </tr>
                                <tr class="bg-light font-weight-bold">
                                    <th>Total:</th>
                                    <td class="text-right">{{ number_format($total, 2) }} TK</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                </div>
                
                {{-- FOOTER BUTTONS --}}
                <div class="card-footer clearfix">
                    <button type="button" class="btn btn-default" onclick="window.print();"><i class="fas fa-print"></i> Print</button>
                    <a href="{{ route('superadmin.raw_material_receivings.index') }}" class="btn btn-primary float-right">Back to List</a>
                </div>
            </div>
        </div>
    </section>

@endsection