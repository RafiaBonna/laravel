@extends('master')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                
                <div class="invoice p-3 mb-3">
                    
                    {{-- Invoice Header (Company Info) --}}
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-sign-out-alt"></i> Raw Material Issue Invoice
                                <small class="float-right">Date: {{ \Carbon\Carbon::parse($stock->issued_date)->format('d M Y') }}</small>
                            </h4>
                        </div>
                    </div>

                    {{-- Invoice From/To Info --}}
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            Issued From (Warehouse)
                            <address>
                                <strong>Main Warehouse</strong><br>
                                {{-- তুমি চাইলে Warehouse এর Address, Phone দিতে পারো --}}
                            </address>
                        </div>
                        
                        <div class="col-sm-4 invoice-col">
                            Issued To (Depot)
                            <address>
                                <strong>{{ $stock->depot->name ?? 'N/A' }}</strong><br>
                                {{-- ধরে নিলাম Depot Model এ address ও phone আছে --}}
                                {{-- Address: {{ $stock->depot->address ?? 'N/A' }}<br> --}}
                                {{-- Phone: {{ $stock->depot->phone ?? 'N/A' }} --}}
                            </address>
                        </div>
                        
                        <div class="col-sm-4 invoice-col">
                            <b>Invoice #00{{ $stock->id }}</b><br>
                            <br>
                            <b>Material Name:</b> {{ $stock->rawMaterial->name }}<br>
                        </div>
                    </div>

                    {{-- Table of Materials --}}
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Material</th>
                                        <th>Issued Qty</th>
                                        <th>Unit</th>
                                        {{-- <th>Cost Price (Per Unit)</th> --}}
                                        {{-- <th>Subtotal</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>{{ $stock->rawMaterial->name }}</td>
                                        <td>{{ $stock->issued_quantity }}</td>
                                        <td>{{ $stock->unit }}</td>
                                        {{-- <td>{{ $stock->cost_price ? number_format($stock->cost_price, 2) . ' TK' : 'N/A' }}</td> --}}
                                        {{-- <td>
                                            @php
                                                $subtotal = $stock->cost_price ? $stock->cost_price * $stock->issued_quantity : 0;
                                            @endphp
                                            {{ $stock->cost_price ? number_format($subtotal, 2) . ' TK' : 'N/A' }}
                                        </td> --}}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Totals (Cost Price না থাকলে শুধু Quantity দেখাবে) --}}
                    {{-- যদি Cost Price দরকার না হয়, এই অংশটি বাদ দিতে পারেন --}}
                    {{-- <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6">
                            <p class="lead">Summary</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Total Issued Qty:</th>
                                        <td class="text-right"><b>{{ $stock->issued_quantity }} {{ $stock->unit }}</b></td>
                                    </tr>
                                    <tr>
                                        <th>Total Cost:</th>
                                        <td class="text-right"><b>{{ $stock->cost_price ? number_format($subtotal, 2) . ' TK' : 'N/A' }}</b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div> --}}

                    {{-- Print and Back Options --}}
                    <div class="row no-print">
                        <div class="col-12">
                            {{-- Print Button --}}
                            <a href="#" onclick="window.print(); return false;" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                            
                            {{-- Back to List Button --}}
                            <a href="{{ route('stockout.index') }}" class="btn btn-primary float-right" style="margin-right: 5px;">
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