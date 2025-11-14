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
                <form action="{{ route('superadmin.sales.store') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        {{-- Depo Selection --}}
                        <div class="form-group row">
                            <label for="depo_id" class="col-md-2 col-form-label">Select Depo <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select name="depo_id" id="depo_id" class="form-control" required>
                                    <option value="">Select a Depo</option>
                                    @foreach($depos as $depo)
                                        <option value="{{ $depo->id }}">{{ $depo->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Invoice Date --}}
                        <div class="form-group row">
                            <label for="invoice_date" class="col-md-2 col-form-label">Invoice Date <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <hr>

                        {{-- Product Table --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <h5>Product Details</h5>
                                <table class="table table-bordered" id="product_table">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%">Product Name</th>
                                            <th style="width: 20%">Batch No.</th>
                                            <th style="width: 15%">Available Stock</th>
                                            <th style="width: 10%">Quantity <span class="text-danger">*</span></th>
                                            <th style="width: 15%">Unit Price <span class="text-danger">*</span></th>
                                            <th style="width: 10%">Sub Total</th>
                                            <th style="width: 5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @include('superadmin.sales.partials.product_row', ['rowId' => 0, 'products' => $products])
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right"><strong>Grand Total:</strong></td>
                                            <td><input type="text" name="total_amount" id="grand_total" class="form-control" readonly value="0.00"></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <button type="button" id="add_row" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add Another Product</button>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save & Send for Approval</button>
                            <a href="{{ route('superadmin.sales.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let row_count = 1;

    function loadProductBatches(row) {
        let productId = row.find('.product-select').val();
        let batchSelect = row.find('.batch-select');
        let priceInput = row.find('.price-input');
        let quantityInput = row.find('.quantity-input');

        batchSelect.empty().append('<option value="">Loading Batches...</option>');
        priceInput.val('0.00');
        quantityInput.val(1).prop('disabled', true);

        if (productId) {
            let url = '{{ route('superadmin.sales.api.product-stock.batches', ['productId' => 'PRODUCT_ID']) }}'.replace('PRODUCT_ID', productId);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(batches) {
                    batchSelect.empty().append('<option value="">Select Batch</option>');
                    if (batches.length > 0) {
                        $.each(batches, function(i, batch) {
                            batchSelect.append('<option value="'+batch.id+'" data-stock="'+batch.available_quantity+'" data-price="'+batch.unit_price+'">'+batch.batch_no+' (Stock: '+batch.available_quantity+')</option>');
                        });
                        batchSelect.prop('disabled', false);
                    } else {
                        batchSelect.append('<option value="">No Stock Available</option>').prop('disabled', true);
                    }
                },
                error: function() {
                    batchSelect.empty().append('<option value="">Error Loading Batches</option>').prop('disabled', true);
                }
            });
        } else {
            batchSelect.empty().append('<option value="">Select Product First</option>').prop('disabled', true);
        }
    }

    // Product change
    $(document).on('change', '.product-select', function() {
        let row = $(this).closest('tr');
        loadProductBatches(row);
        row.find('.sub-total').val('0.00');
        updateTotal();
    });

    // Batch change
    $(document).on('change', '.batch-select', function() {
        let row = $(this).closest('tr');
        let selectedOption = $(this).find('option:selected');
        let unitPrice = selectedOption.data('price') || 0;
        let availableStock = selectedOption.data('stock') || 0;

        row.find('.price-input').val(unitPrice.toFixed(2));
        row.find('.stock-available').val(availableStock);
        row.find('.quantity-input').prop('disabled', false).val(1).trigger('input');
    });

    // Add row
    $('#add_row').click(function() {
        let newRow = $(`  
            <tr id="row_${row_count}">  
                <td>
                    <select name="items[${row_count}][product_id]" class="form-control product-select" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><select name="items[${row_count}][product_stock_id]" class="form-control batch-select" required disabled><option value="">Select Product First</option></select></td>
                <td><input type="text" name="stock_available_${row_count}" class="form-control stock-available" readonly value="0"></td>
                <td><input type="number" name="items[${row_count}][quantity]" class="form-control quantity-input" min="1" required disabled value="1"></td>
                <td><input type="number" name="items[${row_count}][unit_price]" class="form-control price-input" step="0.01" min="0" required value="0.00"></td>
                <td><input type="text" name="items[${row_count}][sub_total]" class="form-control sub-total" readonly value="0.00"></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i> Remove</button></td>
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

    // Quantity / Price change
    $(document).on('input', '.quantity-input, .price-input', function() {
        let row = $(this).closest('tr');
        let quantity = parseFloat(row.find('.quantity-input').val()) || 0;
        let price = parseFloat(row.find('.price-input').val()) || 0;
        let subTotal = quantity * price;
        let availableStock = parseFloat(row.find('.stock-available').val()) || 0;

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

    $('.product-select').first().trigger('change');
    updateTotal(); 
});
</script>
@endpush
