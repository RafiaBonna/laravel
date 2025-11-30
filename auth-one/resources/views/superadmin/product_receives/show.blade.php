@extends('master')

@section('content')

<div class="container mt-4">

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Product Receive Invoice</h4>
            <a href="{{ route('superadmin.product-receives.index') }}" class="btn btn-primary btn-sm">Back</a>
        </div>

        <div class="card-body">

            {{-- Header Info --}}
            <table class="table table-borderless mb-4">
                <tr>
                    <th>Receive No:</th>
                    <td>{{ $receive->receive_no }}</td>

                    <th>Receive Date:</th>
                    <td>{{ $receive->receive_date }}</td>
                </tr>

                <tr>
                    <th>Note:</th>
                    <td>{{ $receive->note }}</td>

                    <th>Received By:</th>
                    <td>{{ $receive->user->name ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Total Qty:</th>
                    <td>{{ $receive->total_received_qty }}</td>

                    <th>Total Cost:</th>
                    <td>{{ number_format($receive->total_cost, 2) }}</td>
                </tr>
            </table>

            <hr>

            {{-- Items Table --}}
            <h5 class="mb-3">Received Product Items</h5>

            <table class="table table-bordered">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>Id</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Sub total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($receive->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->received_quantity }}</td>
                            <td>{{ number_format($item->cost_rate, 2) }}</td>
                            <td>{{ number_format($item->total_item_cost, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Total Cost:</th>
                        <th>{{ number_format($receive->total_cost, 2) }}</th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>

</div>

@endsection
