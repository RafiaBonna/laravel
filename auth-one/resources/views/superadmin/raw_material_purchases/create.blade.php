@extends('master')

@section('content')
<div class="container mt-4">
    <h4>Add Raw Material Purchase</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('superadmin.raw-material-purchases.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Invoice Number</label>
                <input type="text" name="invoice_number" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Invoice Date</label>
                <input type="date" name="invoice_date" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Supplier</label>
                <select name="supplier_id" class="form-control" required>
                    <option value="">-- Select Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <table class="table table-bordered" id="itemsTable">
            <thead class="table-light">
                <tr>
                    <th>Existing Material</th>
                    <th>New Material Name</th>
                    <th>Unit</th>
                    <th>Batch</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="items[0][raw_material_id]" class="form-select raw-select">
                            <option value="">-- Select --</option>
                            @foreach($rawMaterials as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->unit_of_measure }})</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" name="items[0][new_material_name]" class="form-control" placeholder="If new"></td>
                    <td><input type="text" name="items[0][unit_of_measure]" class="form-control" placeholder="KG/Litre"></td>
                    <td><input type="text" name="items[0][batch_number]" class="form-control"></td>
                    <td><input type="number" name="items[0][quantity]" class="form-control qty" step="0.01"></td>
                    <td><input type="number" name="items[0][unit_price]" class="form-control price" step="0.01"></td>
                    <td><input type="number" name="items[0][total_price]" class="form-control total" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" id="addRow" class="btn btn-secondary mb-3">+ Add Item</button>

        <div class="row mb-3">
            <div class="col-md-4 ms-auto">
                <label>Discount</label>
                <input type="number" name="discount_amount" class="form-control" step="0.01" value="0">
                <label>Grand Total</label>
                <input type="number" name="grand_total" id="grand_total" class="form-control" step="0.01" readonly>
                <input type="hidden" name="calculated_total" id="calculated_total">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Purchase</button>
    </form>
</div>

<script>
let row = 1;

// Add new row
document.getElementById('addRow').addEventListener('click', () => {
    const tbody = document.querySelector('#itemsTable tbody');
    const tr = tbody.querySelector('tr').cloneNode(true);
    tr.querySelectorAll('input, select').forEach(input => {
        input.value = '';
        let name = input.name.replace(/\d+/, row);
        input.name = name;
    });
    tbody.appendChild(tr);
    row++;
});

// Remove row
document.addEventListener('click', function(e) {
    if(e.target.classList.contains('removeRow')) {
        if(document.querySelectorAll('#itemsTable tbody tr').length > 1)
            e.target.closest('tr').remove();
    }
});

// Auto total
document.addEventListener('input', function(e) {
    if(e.target.classList.contains('qty') || e.target.classList.contains('price')) {
        const tr = e.target.closest('tr');
        const qty = parseFloat(tr.querySelector('.qty').value) || 0;
        const price = parseFloat(tr.querySelector('.price').value) || 0;
        const total = qty * price;
        tr.querySelector('.total').value = total.toFixed(2);
    }
    calculateGrandTotal();
});

function calculateGrandTotal() {
    let total = 0;
    document.querySelectorAll('.total').forEach(el => total += parseFloat(el.value) || 0);
    document.getElementById('grand_total').value = total.toFixed(2);
    document.getElementById('calculated_total').value = total.toFixed(2);
}
</script>
@endsection
