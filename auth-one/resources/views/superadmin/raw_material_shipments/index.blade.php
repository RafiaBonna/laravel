@extends('master')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Raw Material Shipments (Transfer History)</h1>
            <a href="{{ route('superadmin.raw_material_shipments.create') }}" class="btn btn-danger btn-sm mt-2">
                <i class="fas fa-plus-circle"></i> Record New Shipment
            </a>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Raw Material Transfers</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <table class="table table-bordered table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Material</th>
                                <th>Quantity</th>
                                <th>Destination Depo</th>
                                <th>Shipment Date</th>
                                <th>Status</th>
                                <th>Shipped By</th>
                                <th>Received By</th>
                                <th>Received Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shipments as $shipment)
                                <tr>
                                    <td>{{ $shipment->id }}</td>
                                    <td>{{ $shipment->rawMaterial->name ?? 'N/A' }} ({{ $shipment->rawMaterial->unit ?? '' }})</td>
                                    <td>{{ number_format($shipment->quantity, 2) }} {{ $shipment->rawMaterial->unit ?? '' }}</td>
                                    <td>{{ $shipment->depo->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($shipment->shipment_date)->format('d M, Y') }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($shipment->status) {
                                                'PENDING' => 'warning',
                                                'RECEIVED' => 'success',
                                                'SHIPPED' => 'info',
                                                'CANCELLED' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span class="badge badge-{{ $badgeClass }}">
                                            {{ $shipment->status }}
                                        </span>
                                    </td>
                                    <td>{{ $shipment->user->name ?? 'N/A' }}</td>
                                    <td>{{ $shipment->receiver->name ?? 'N/A' }}</td>
                                    <td>{{ $shipment->received_date ? \Carbon\Carbon::parse($shipment->received_date)->format('d M, Y h:i A') : 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
