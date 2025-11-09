@extends('master')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Raw Material Stock In (Purchase)</h6>
            <a href="{{ route('superadmin.raw-material-purchases.index') }}" class="btn btn-secondary btn-sm">
                View Invoices
            </a>
        </div>
        <div class="card-body">
            
            {{-- Flash Messages --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger"><strong>Validation Error:</strong> Please correct the errors below.</div>
            @endif

            <form action="{{ route('superadmin.raw-material-purchases.store') }}" method="POST">
                @csrf
                
                {{-- Master Data: Supplier, Date, Invoice No. --}}
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="invoice_number">Invoice No. <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" name="invoice_number" value="{{ old('invoice_number') }}" required>
                        @error('invoice_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="invoice_date">Purchase Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('invoice_date') is-invalid @enderror" name="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                        @error('invoice_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                        <select class="form-control @error('supplier_id') is-invalid @enderror" name="supplier_id" required>
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <hr>
                
                {{-- Dynamic Items Table --}}
                <h6 class="font-weight-bold text-primary">Purchase Items</h6>
                @error('items')<div class="alert alert-danger">{{ $message }}</div>@enderror
                
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="purchase_items_table">
                        <thead>
                            <tr>
                                <th>Material <span class="text-danger">*</span></th>
                                <th>Unit</th>
                                <th>Batch No. <span class="text-danger">*</span></th>
                                <th>Quantity <span class="text-danger">*</span></th>
                                <th>Unit Price <span class="text-danger">*</span></th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="item_rows_container">
                            {{-- Item rows will be appended here by JS --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" class="text-right">
                                    <button type="button" class="btn btn-success btn-sm" id="add_item_btn">+ Add Item</button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right font-weight-bold">Sub Total:</td>
                                <td id="sub_total_display" class="font-weight-bold text-right">0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Summary and Final Total --}}
                <div class="row justify-content-end">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label text-right">Discount Amount:</label>
                            <div class="col-sm-7">
                                <input type="number" step="0.01" class="form-control" id="discount_amount" name="discount_amount" value="{{ old('discount_amount', 0) }}" min="0">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label text-right font-weight-bold">Grand Total:</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control font-weight-bold @error('grand_total') is-invalid @enderror" id="grand_total" name="grand_total" value="{{ old('grand_total') }}" readonly required>
                                {{-- Hidden field for security validation --}}
                                <input type="hidden" id="calculated_total" name="calculated_total">
                                @error('grand_total')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea class="form-control" name="notes" rows="2">{{ old('notes') }}</textarea>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Confirm Purchase & Stock In</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> {{-- jQuery নিশ্চিত করুন --}}
<script>
    // Raw Material Data (Blade থেকে JSON এ আনা)
    const rawMaterials = @json($rawMaterials);
    let itemCounter = 0;

    function formatCurrency(amount) {
        return parseFloat(amount).toFixed(2);
    }

    function calculateTotal() {
        let subTotal = 0;
        $('#item_rows_container tr').each(function() {
            const total = parseFloat($(this).find('.item-total-price').val() || 0);
            subTotal += total;
        });

        const discount = parseFloat($('#discount_amount').val() || 0);
        let grandTotal = subTotal - discount;
        if (grandTotal < 0) grandTotal = 0;

        $('#sub_total_display').text(formatCurrency(subTotal));
        $('#grand_total').val(formatCurrency(grandTotal));
        $('#calculated_total').val(formatCurrency(grandTotal)); 
    }

    function updateItemTotal(row) {
        let quantity = parseFloat(row.find('.item-quantity').val() || 0);
        let price = parseFloat(row.find('.item-unit-price').val() || 0);
        
        if (quantity < 0) quantity = 0;
        if (price < 0) price = 0;

        const total = quantity * price;

        row.find('.item-total-price').val(formatCurrency(total));
        row.find('.item-total-display').text(formatCurrency(total));
        
        calculateTotal();
    }

    function addNewItemRow() {
        itemCounter++;
        const index = itemCounter;
        
        // Material Options HTML তৈরি
        let materialOptions = '<option value="">Select Material</option>';
        rawMaterials.forEach(material => {
            materialOptions += `<option value="${material.id}" data-unit="${material.unit_of_measure}">${material.name}</option>`;
        });

        const newRow = `
            <tr data-row-id="${index}">
                <td>
                    <select class="form-control item-material-select" name="items[${index}][raw_material_id]" required>
                        ${materialOptions}
                    </select>
                </td>
                <td><span class="item-unit-display"></span></td>
                <td>
                    <input type="text" class="form-control" name="items[${index}][batch_number]" required>
                </td>
                <td>
                    <input type="number" step="0.01" min="0.01" class="form-control item-quantity" name="items[${index}][quantity]" value="1" required>
                </td>
                <td>
                    <input type="number" step="0.01" min="0" class="form-control item-unit-price" name="items[${index}][unit_price]" value="0" required>
                </td>
                <td class="item-total-display text-right">0.00
                    <input type="hidden" class="item-total-price" name="items[${index}][total_price]" value="0.00">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-item-btn">X</button>
                </td>
            </tr>
        `;
        $('#item_rows_container').append(newRow);
        updateItemTotal($(`tr[data-row-id="${index}"]`)); // Initial calculation for new row
    }
    
    // Initial load and event listeners
    $(document).ready(function() {
        // প্রথম রো যোগ
        addNewItemRow(); 
        
        // Add Item Button
        $('#add_item_btn').on('click', addNewItemRow);

        // Remove Item Button
        $(document).on('click', '.remove-item-btn', function() {
            $(this).closest('tr').remove();
            calculateTotal(); 
        });

        // Quantity / Price চেঞ্জ হলে টোটাল আপডেট
        $(document).on('change keyup', '.item-quantity, .item-unit-price', function() {
            const row = $(this).closest('tr');
            updateItemTotal(row);
        });

        // Discount চেঞ্জ হলে গ্র্যান্ড টোটাল আপডেট
        $('#discount_amount').on('change keyup', calculateTotal);
        
        // Material সিলেক্ট হলে ইউনিট আপডেট
        $(document).on('change', '.item-material-select', function() {
            const selectedOption = $(this).find('option:selected');
            const unit = selectedOption.data('unit');
            $(this).closest('tr').find('.item-unit-display').text(unit || '');
            updateItemTotal($(this).closest('tr'));
        });

        // Initial calculation
        calculateTotal(); 
    });
</script>
@endpush