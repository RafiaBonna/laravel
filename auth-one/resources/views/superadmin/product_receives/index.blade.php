{{-- resources/views/superadmin/product_receives/index.blade.php --}}

@extends('master') 
{{-- ধরে নিলাম আপনার main layout ফাইলটি layouts/app.blade.php --}}

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
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table id="receiveTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Receive No</th>
                                <th>Receive Date</th>
                                <th>Total Qty</th>
                                <th>Received By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($receives as $receive)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $receive->receive_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($receive->receive_date)->format('d-M-Y') }}</td>
                                <td>{{ number_format($receive->total_received_qty, 2) }}</td>
                                <td>{{ $receive->receiver->name ?? 'N/A' }}</td>
                                <td>
                                    {{-- View Button --}}
                                    <a href="#" class="btn btn-info btn-sm" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- Edit/Delete (Optional, as stock transactions are sensitive) --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $receives->links() }}
                    </div>
                </div>
                </div>
            </div>
    </div>
</div>
@endsection