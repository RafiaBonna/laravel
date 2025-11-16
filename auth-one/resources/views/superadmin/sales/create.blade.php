@extends('master')

@section('title', 'Create New Sales Invoice')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">New Sales Invoice (For Depo)</h3>
                </div>
                {{-- অ্যাকশন URLটি এখন superadmin/sales এ পয়েন্ট করবে --}}
                <form action="{{ route('superadmin.sales.store') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        {{-- Success/Error Messages --}}
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @elseif(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        
                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        {{-- Invoice Header Info --}}
                        <div class="form-group row">
                            <label for="depo_id" class="col-md-2 col-form-label">Select Depo <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select name="depo_id" id="depo_id" class="form-control" required>
                                    <option value="">Select a Depo</option>
                                    @foreach($depos as $depo)
                                        <option value="{{ $depo->id }}" {{ old('depo_id') == $depo->id ? 'selected' : '' }}>{{ $depo->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <label for="invoice_date" class="col-md-2 col-form-label">Invoice Date <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <hr>
                        
                        {{-- Product Item Table --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="product_table">
                                <thead>
                                    <tr>
                                        <th style="width: 25%">Product <span class="text-danger">*</span></th>
                                        <th style="width: 20%">Batch/Stock ID <span class="text-danger">*</span></th>
                                        <th style="width: 10%">Available Stock</th>
                                        <th style="width: 10%">Quantity <span class="text-danger">*</span></th>
                                        <th style="width: 15%">Unit Price <span class="text-danger">*</span></th>
                                        <th style="width: 15%">Sub Total</th>
                                        <th style="width: 5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Initial Row (row index 0) --}}
                                    <tr>
                                        <td>
                                            <select name="items[0][product_id]" class="form-control product-select" required>
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="items[0][product_stock_id]" class="form-control batch-select" required disabled>
                                                <option value="">Select Product First</option>
                                            </select>
                                        </td>
                                        <td>
                                            {{-- NOTE: name attribute removed to avoid confusion with form submission, readonly added --}}
                                            <input type="text" class="form-control stock-available" readonly value="0"> 
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][quantity]" class="form-control quantity-input" min="1" required disabled value="1">
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][unit_price]" class="form-control price-input" step="0.01" min="0" required value="0.00">
                                        </td>
                                        <td>
                                            <input type="text" name="items[0][sub_total]" class="form-control sub-total" readonly value="0.00">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row" disabled><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-right font-weight-bold">Grand Total:</td>
                                        <td>
                                            <input type="text" id="grand_total" class="form-control" readonly value="0.00">
                                        </td>
                                        <td>
                                            <button type="button" id="add-row" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Add</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create Invoice & Send for Approval</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ✅ FIX: নিশ্চিত করা হলো যে jQuery এবং DOM পুরোপুরি লোড হওয়ার পরই কোড রান করবে
$(function() { 
    
    let row_count = 1;

    // ----------------------------------------------------
    // Core Logic: Load Batches and Auto-fill Stock/Price
    // ----------------------------------------------------
    
    function loadProductBatches(row) {
        let productId = row.find('.product-select').val();
        let batchSelect = row.find('.batch-select');
        let stockInput = row.find('.stock-available');
        let priceInput = row.find('.price-input');
        let qtyInput = row.find('.quantity-input');
        
        // Reset fields
        stockInput.val(0);
        priceInput.val(0.00);
        row.find('.sub-total').val(0.00);
        qtyInput.prop('disabled', true).val(1); 
        
        batchSelect.prop('disabled', true).html('<option value="">Loading Batches...</option>');

        if (productId) {
            // ✅ FIX: সরাসরি URL Path ব্যবহার করা হলো
            let url = `/superadmin/sales/api/product-stock/batches/${productId}`;
            
            console.log(`[DEBUG URL] Requesting: ${url}`);
            

            $.get(url, function(batches) {
                console.log("[DEBUG SUCCESS] Batches received:", batches);

                batchSelect.html('<option value="">Select Batch</option>');
                
                if (batches.length > 0) {
                    
                    // 1. Dropdown অপশন দিয়ে ফিল করা
                    batches.forEach(function(batch) {
                        batchSelect.append(`<option 
                            value="${batch.id}" 
                            data-available-stock="${batch.available_quantity}"
                            data-unit-price="${batch.unit_price}"
                        >Batch: ${batch.batch_no} (Stock: ${batch.available_quantity})</option>`);
                    });

                    // 2. প্রথম ব্যাচটির ডেটা সরাসরি নেওয়া
                    const firstBatch = batches[0];
                    const availableStock = firstBatch.available_quantity;
                    const unitPrice = firstBatch.unit_price;

                    // 3. ফিল্ডগুলো অটো-ফিল করা
                    batchSelect.val(firstBatch.id); // প্রথম ব্যাচ সিলেক্ট করা হলো
                    stockInput.val(availableStock);
                    priceInput.val(unitPrice.toFixed(2));
                    
                    // 4. Quantity ফিল্ড এনাবল করা
                    qtyInput.prop('disabled', false).val(1);
                    batchSelect.prop('disabled', false);

                    // Calculation (যদি Quantity 1 থাকে)
                    const subTotal = 1 * unitPrice;
                    row.find('.sub-total').val(subTotal.toFixed(2));
                    
                } else {
                    batchSelect.html('<option value="">No Stock Available</option>');
                }
                
                updateTotal(); // গ্র্যান্ড টোটাল আপডেট
                
            }).fail(function(xhr) {
                console.error("[DEBUG FAIL] Failed to load batches. Status:", xhr.status, "Response:", xhr.responseText);
                batchSelect.html('<option value="">Failed to load batches</option>');
                updateTotal();
            });
        } else {
            batchSelect.prop('disabled', true).html('<option value="">Select Product First</option>');
            updateTotal();
        }
    }

    // Product Select Change Event
    $(document).on('change', '.product-select', function() {
        loadProductBatches($(this).closest('tr'));
    });
    
    // Batch Select Change Event (If user manually selects another batch)
    $(document).on('change', '.batch-select', function() {
        let row = $(this).closest('tr');
        let selectedOption = $(this).find('option:selected');
        
        let availableStock = selectedOption.data('available-stock') || 0;
        let unitPrice = selectedOption.data('unit-price') || 0.00;

        row.find('.stock-available').val(availableStock);
        row.find('.price-input').val(unitPrice.toFixed(2));

        row.find('.quantity-input').prop('disabled', false).val(1);
        row.find('.quantity-input').trigger('input'); 
    });


    // ----------------------------------------------------
    // Calculation Logic
    // ----------------------------------------------------

    // Quantity / Price change
    $(document).on('input', '.quantity-input, .price-input', function() {
        let row = $(this).closest('tr');
        let quantity = parseFloat(row.find('.quantity-input').val()) || 0;
        let price = parseFloat(row.find('.price-input').val()) || 0;
        let subTotal = quantity * price;
        let availableStock = parseFloat(row.find('.stock-available').val()) || 0;

        // Stock Validation (if Quantity > Available Stock)
        if (quantity > availableStock) {
            alert(`Quantity cannot exceed available stock (${availableStock}).`);
            row.find('.quantity-input').val(availableStock);
            quantity = availableStock;
            subTotal = quantity * price;
        }

        row.find('.sub-total').val(subTotal.toFixed(2));
        updateTotal();
    });

    // Grand total
    function updateTotal() {
        let grandTotal = 0;
        $('.sub-total').each(function() {
            grandTotal += parseFloat($(this).val()) || 0;
        });
        $('#grand_total').val(grandTotal.toFixed(2));
    }


    // ----------------------------------------------------
    // Row Management
    // ----------------------------------------------------
    
    // Add new row
    $('#add-row').click(function() {
        let newRow = $(`
            <tr>
                <td>
                    <select name="items[${row_count}][product_id]" class="form-control product-select" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="items[${row_count}][product_stock_id]" class="form-control batch-select" required disabled>
                        <option value="">Select Product First</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control stock-available" readonly value="0">
                </td>
                <td>
                    <input type="number" name="items[${row_count}][quantity]" class="form-control quantity-input" min="1" required disabled value="1">
                </td>
                <td>
                    <input type="number" name="items[${row_count}][unit_price]" class="form-control price-input" step="0.01" min="0" required value="0.00">
                </td>
                <td>
                    <input type="text" name="items[${row_count}][sub_total]" class="form-control sub-total" readonly value="0.00">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i> Remove</button>
                </td>
            </tr>
        `);
        $('#product_table tbody').append(newRow);
        row_count++;
    });

    // Remove row
    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
        updateTotal();
    });

    updateTotal(); 
});
</script>
@endpush