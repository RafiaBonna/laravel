@extends('master')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Incoming Raw Material Shipments</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Shipments Addressed to: {{ Auth::user()->depo->name ?? 'N/A' }}</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    <table class="table table-bordered table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th>Shipment ID</th>
                                <th>Material</th>
                                <th>Quantity</th>
                                <th>Shipped Date</th>
                                <th>Shipped By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shipments as $shipment)
                                <tr>
                                    <td>{{ $shipment->id }}</td>
                                    <td>{{ $shipment->rawMaterial->name ?? 'N/A' }} ({{ $shipment->rawMaterial->unit ?? '' }})</td>
                                    <td>{{ number_format($shipment->quantity, 2) }} {{ $shipment->rawMaterial->unit ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($shipment->shipment_date)->format('d M, Y') }}</td>
                                    <td>{{ $shipment->user->name ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $badgeClass = $shipment->status === 'PENDING' ? 'warning' : 'success';
                                        @endphp
                                        <span class="badge badge-{{ $badgeClass }}">
                                            {{ $shipment->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($shipment->status === 'PENDING')
                                            <form action="{{ route('depo.shipments.receive', $shipment) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to receive this shipment? This action will add stock to your Depo Inventory.');">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Receive & Stock In</button>
                                            </form>
                                        @else
                                            <span class="text-success font-weight-bold">Received on {{ $shipment->received_date ? \Carbon\Carbon::parse($shipment->received_date)->format('d M, Y') : '' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No incoming raw material shipments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
