{{-- resources/views/superadmin/product_receives/show.blade.php --}}

@extends('master') 
{{-- ধরে নিলাম আপনার master layout ফাইলটি 'master.blade.php' --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">📝 Product Receive Invoice Details</h3>
                    <div class="card-tools">
                        {{-- প্রিন্ট বাটন --}}
                        <button class="btn btn-sm btn-light" onclick="window.print()">
                            <i class="fas fa-print"></i> Print
                        </button>
                        {{-- ব্যাক বাটন --}}
                        <a href="{{ route('superadmin.product-receives.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    
                    {{-- Invoice Header Section --}}
                    <div class="row invoice-info mb-4">
                        <div class="col-sm-4 invoice-col">
                            <b>Invoice No:</b> {{ $receive->receive_no }}<br>
                            <b>Receive Date:</b> {{ \Carbon\Carbon::parse($receive->receive_date)->format('d F, Y') }}<br>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <b>Received By:</b> {{ $receive->receiver->name ?? 'System User' }}<br>
                            <b>Total Items:</b> {{ $receive->items->count() }}<br>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <b>Total Quantity:</b> **{{ number_format($receive->total_received_qty, 2) }}**<br>
                            <b>Note:</b> {{ $receive->note ?? 'N/A' }}
                        </div>
                    </div>
                    
                    <hr>

                    {{-- Item Details Table --}}
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <h4>Received Products</h4>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">SL</th>
                                        <th style="width: 30%">Product Name</th>
                                        <th style="width: 15%">Batch No</th>
                                        <th style="width: 10%">Quantity</th>
                                        <th style="width: 15%" class="text-right">Cost Rate</th>
                                        <th style="width: 15%" class="text-right">Total Cost</th>
                                        <th style="width: 10%">Expiry Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalAmount = 0;
                                    @endphp

                                    @foreach($receive->items as $item)
                                        @php
                                            $itemTotal = $item->received_quantity * $item->cost_rate;
                                            $totalAmount += $itemTotal;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->product->name ?? 'Product Deleted' }}</td>
                                            <td>{{ $item->batch_no }}</td>
                                            <td>{{ number_format($item->received_quantity, 2) }}</td>
                                            <td class="text-right">{{ number_format($item->cost_rate, 2) }}</td>
                                            <td class="text-right">{{ number_format($itemTotal, 2) }}</td>
                                            <td>
                                                @if($item->expiry_date)
                                                    {{ \Carbon\Carbon::parse($item->expiry_date)->format('d-M-Y') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-right">Grand Total Cost:</th>
                                        <th class="text-right">{{ number_format($totalAmount, 2) }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- Footer/Signature Section (ঐচ্ছিক) --}}
                    <div class="row mt-5">
                        <div class="col-6 text-center">
                            <p class="border-top pt-2">Receiver Signature</p>
                        </div>
                        <div class="col-6 text-center">
                            <p class="border-top pt-2">Prepared By: {{ $receive->receiver->name ?? 'System' }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- এখানে Print-এর জন্য CSS যোগ করা যেতে পারে, তবে সাধারণ প্রিন্ট কাজ করবে --}}
@endsection