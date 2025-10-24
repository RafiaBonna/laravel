@extends('master')
{{-- এখানে অবশ্যই 'master' ব্যবহার করা হয়েছে, যা তোমার অন্যান্য ফাইলগুলির সাথে মেলে --}}

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                
                {{-- AdminLTE Invoice Box --}}
                <div class="invoice p-3 mb-3">
                    
                    {{-- Invoice Header (Company Info) --}}
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-receipt"></i> Raw Material Receive Invoice
                                <small class="float-right">Date: {{ \Carbon\Carbon::parse($stock->received_date)->format('d M Y') }}</small>
                            </h4>
                        </div>
                    </div>

                    {{-- Invoice From/To Info --}}
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            From Supplier
                            <address>
                                <strong>{{ $stock->supplier->name }}</strong><br>
                                {{-- ধরে নিলাম Supplier Model এ address ও phone আছে --}}
                                {{-- Address: {{ $stock->supplier->address ?? 'N/A' }}<br> --}}
                                {{-- Phone: {{ $stock->supplier->phone ?? 'N/A' }} --}}
                                Supplier ID: #{{ $stock->supplier_id }}
                            </address>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            To Warehouse
                            <address>
                                <strong>SCM Company</strong><br>
                                {{-- তোমার কোম্পানির ঠিকানা এখানে যোগ করো --}}
                                [Warehouse Address]<br>
                                [Phone/Contact Info]
                            </address>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <b>Invoice ID #{{ $stock->id }}</b><br>
                            <b>Material:</b> {{ $stock->rawMaterial->name }}<br>
                            <b>Received Date:</b> {{ \Carbon\Carbon::parse($stock->received_date)->format('d/m/Y') }}
                        </div>
                    </div>
                    
                    <hr>

                    {{-- Items Table --}}
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Material Name</th>
                                    <th>Unit</th>
                                    <th class="text-right">Quantity</th>
                                    <th class="text-right">Unit Price (TK)</th>
                                    <th class="text-right">Subtotal (TK)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $stock->rawMaterial->name }}</td>
                                    <td>{{ $stock->unit }}</td>
                                    <td class="text-right">{{ $stock->received_quantity }}</td>
                                    <td class="text-right">{{ $stock->unit_price ? number_format($stock->unit_price, 2) : 'N/A' }}</td>
                                    <td class="text-right">
                                        @php
                                            $total = $stock->unit_price ? ($stock->received_quantity * $stock->unit_price) : 0;
                                        @endphp
                                        @if ($stock->unit_price)
                                            {{ number_format($total, 2) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <p class="lead">Notes:</p>
                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                Raw material received and successfully added to inventory.
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="lead">Summary</p>

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td class="text-right">{{ $stock->unit_price ? number_format($total, 2) . ' TK' : 'N/A' }}</td>
                                    </tr>
                                    {{-- If you have Tax/Discount, add rows here --}}
                                    <tr>
                                        <th>Total:</th>
                                        <td class="text-right"><b>{{ $stock->unit_price ? number_format($total, 2) . ' TK' : 'N/A' }}</b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Print and Back Options (Will not print) --}}
                    <div class="row no-print">
                        <div class="col-12">
                            {{-- Print Button --}}
                            <a href="#" onclick="window.print(); return false;" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                            
                            {{-- Back to List Button --}}
                            <a href="{{ route('stockin.index') }}" class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-list"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection