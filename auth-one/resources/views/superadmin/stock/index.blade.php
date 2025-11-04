@extends('master') 

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Raw Material Stock History</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Stock Movements (IN/OUT)</h3>
                </div>
                
                <div class="card-body p-0">

                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date/Time</th>
                                <th>Raw Material</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Reference Document</th>
                                <th>Recorded By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stockMovements as $movement)
                                <tr>
                                    <td>{{ $movement->id }}</td>
                                    <td>{{ $movement->created_at->format('d M, Y H:i A') }}</td>
                                    <td>{{ $movement->rawMaterial->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $movement->type == 'IN' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $movement->type }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($movement->quantity, 2) }} {{ $movement->rawMaterial->unit ?? '' }}</td>
                                    <td>
                                        @if ($movement->reference_type == 'App\Models\RawMaterialReceiving')
                                            {{-- Receiving Invoice এর লিংক (যদি RawMaterialReceivingController এ show মেথড থাকে) --}}
                                            <a href="{{ route('superadmin.raw_material_receivings.show', $movement->reference_id) }}" class="btn btn-xs btn-outline-info">
                                                Receiving Invoice #{{ $movement->reference_id }}
                                            </a>
                                        @else
                                            {{ class_basename($movement->reference_type) }} #{{ $movement->reference_id }}
                                        @endif
                                    </td>
                                    <td>{{ $movement->user->name ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No stock movement history found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination Links --}}
                <div class="card-footer">
                    {{ $stockMovements->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </section>

@endsection