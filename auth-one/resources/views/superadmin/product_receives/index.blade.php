@extends('master')

@section('content')
<div class="content-wrapper p-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Product Receive List</h3>
        <a href="{{ route('superadmin.product-receives.create') }}" class="btn btn-primary">
            + New Receive
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Receive No</th>
                        <th>Date</th>
                        <th>Total Quantity</th>
                        <th>Total Cost</th>
                        <th>Received By</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($receives as $receive)
                    <tr>
                        <td>{{ $receive->receive_no }}</td>
                        <td>{{ $receive->receive_date }}</td>
                        <td>{{ $receive->total_received_qty }}</td>
                        <td>{{ number_format($receive->total_cost, 2) }}</td>
                        <td>{{ $receive->user->name ?? 'N/A' }}</td>
                        <td>
                               <a href="{{ route('superadmin.product-receives.show', $receive->id) }}" 
       class="btn btn-info btn-sm">
       View
    </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-2">
                {{ $receives->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
