{{-- resources/views/superadmin/product_receives/index.blade.php --}}

@extends('master') 
{{-- ধরে নিলাম আপনার main layout ফাইলটি 'master.blade.php' --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">📦 Product Receive List</h3>
                    <div class="card-tools">
                        <a href="{{ route('superadmin.product-receives.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> New Receive Entry
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- ✅ মেসেজ ডিসপ্লে --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- টেবিলকে রেসপনসিভ করার জন্য table-responsive ব্যবহার করা হলো --}}
                    <div class="table-responsive"> 
                        <table id="receiveTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">SL</th>
                                    <th>Receive No (ইনভয়েস)</th>
                                    <th>Receive Date</th>
                                    <th>Total Qty</th>
                                    <th>Received By</th>
                                    <th style="width: 80px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receives as $receive)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="badge badge-info">{{ $receive->receive_no }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($receive->receive_date)->format('d-M-Y') }}</td>
                                    <td>{{ number_format($receive->total_received_qty, 2) }}</td>
                                    <td>{{ $receive->receiver->name ?? 'N/A' }}</td>
                                    <td>
                                        {{-- View Button (Fixed) --}}
                                        <a href="{{ route('superadmin.product-receives.show', $receive->id) }}" class="btn btn-info btn-sm" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @if($receives->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">No product receive entries found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div> {{-- Closes .table-responsive --}}

                    <div class="mt-3">
                        {{ $receives->links() }}
                    </div>
                </div> {{-- Closes .card-body --}}
            </div> {{-- Closes .card (অতিরিক্ত div টি সরানো হয়েছে) --}}
        </div> {{-- Closes .col-12 --}}
    </div> {{-- Closes .row --}}
</div> {{-- Closes .container-fluid --}}
@endsection