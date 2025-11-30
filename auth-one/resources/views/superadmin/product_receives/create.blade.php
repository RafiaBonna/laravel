@extends('master')

@section('content')
<div class="content-wrapper p-4">

    <div class="mb-3">
        <h3>Create Product Receives</h3>
    </div>

    <form action="{{ route('superadmin.product-receives.store') }}" method="POST">
        @csrf

        <div class="card mb-4">
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Receive Date</label>
                        <input type="date" name="receive_date" class="form-control" required>
                    </div>

                    <div class="col-md-8">
                        <label>Note</label>
                        <input type="text" name="note" class="form-control">
                    </div>
                </div>

            </div>
        </div>

        <!-- PRODUCT RECEIVE ITEMS -->
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Receive Items</h5>
                <button type="button" onclick="addRow()" class="btn btn-success btn-sm">+ Add Item</button>
            </div>

            <div class="card-body">
                <table class="table table-bordered" id="items-table">
                    <thead>
                        <tr>
                            <th width="25%">Product</th>
                            <th width="15%">Batch No</th>
                            <th width="15%">Production Date</th>
                            <th width="15%">Expiry Date</th>
                            <th width="10%">Qty</th>
                            <th width="10%">Rate</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>
                                <select name="product_id[]" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="text" name="batch_no[]" class="form-control">
                            </td>

                            <td>
                                <input type="date" name="production_date[]" class="form-control">
                            </td>

                            <td>
                                <input type="date" name="expiry_date[]" class="form-control">
                            </td>

                            <td>
                                <input type="number" step="0.01" name="received_quantity[]" class="form-control" required>
                            </td>

                            <td>
                                <input type="number" step="0.01" name="cost_rate[]" class="form-control">
                            </td>

                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>
                            </td>
                        </tr>

                    </tbody>

                </table>
            </div>

        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Submit Receive</button>
        </div>

    </form>

</div>

<!-- JS -->
<script>
function addRow() {
    let row = `
    <tr>
        <td>
            <select name="product_id[]" class="form-control" required>
                <option value="">Select</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </td>

        <td><input type="text" name="batch_no[]" class="form-control"></td>
        <td><input type="date" name="production_date[]" class="form-control"></td>
        <td><input type="date" name="expiry_date[]" class="form-control"></td>

        <td><input type="number" step="0.01" name="received_quantity[]" class="form-control" required></td>
        <td><input type="number" step="0.01" name="cost_rate[]" class="form-control"></td>

        <td>
            <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">X</button>
        </td>
    </tr>
    `;

    document.querySelector("#items-table tbody").insertAdjacentHTML('beforeend', row);
}

function removeRow(button) {
    button.closest('tr').remove();
}
</script>
@endsection
