{{-- resources/views/superadmin/product_receives/create.blade.php --}}

@extends('master') 

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">➕ New Product Receive Entry</h3>
                </div>
                
                {{-- Form শুরু --}}
                <form action="{{ route('superadmin.product-receives.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        
                        {{-- Header Section --}}
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="receive_no">Receive No</label>
                                <input type="text" name="receive_no" id="receive_no" class="form-control" 
                                       value="{{ old('receive_no', $nextReceiveNo) }}" readonly>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="receive_date">Receive Date <span class="text-danger">*</span></label>
                                <input type="date" name="receive_date" id="receive_date" class="form-control @error('receive_date') is-invalid @enderror" 
                                       value="{{ old('receive_date', date('Y-m-d')) }}" required>
                                @error('receive_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="note">Note (Optional)</label>
                                <input type="text" name="note" id="note" class="form-control @error('note') is-invalid @enderror" 
                                       value="{{ old('note') }}" placeholder="Any relevant notes">
                                @error('note') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Item Details Table --}}
                        <h5 class="mt-4 mb-3">Product Details</h5>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-bordered table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product <span class="text-danger">*</span></th>
                                            <th>Batch No <span class="text-danger">*</span></th>
                                            <th style="width: 100px;">Quantity <span class="text-danger">*</span></th>
                                            <th class="text-right">MRP</th>
                                            <th class="text-right">Retail</th>
                                            <th class="text-right">Distributor</th>
                                            <th class="text-right">Depo Selling</th>
                                            <th style="width: 100px;">Cost Rate <span class="text-danger">*</span></th>
                                            <th style="width: 120px;">Production Date</th>
                                            <th style="width: 120px;">Expiry Date</th>
                                            <th style="width: 50px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="item-table-body">
                                        {{-- Initial Row --}}
                                        @include('superadmin.product_receives.partials.receive_item_row', ['i' => 0])
                                        
                                        {{-- If validation failed, load old data --}}
                                        @if(old('items'))
                                            @foreach(old('items') as $index => $item)
                                                {{-- Skip the initial row (index 0) which is already included --}}
                                                @if($index > 0)
                                                    @include('superadmin.product_receives.partials.receive_item_row', ['i' => $index, 'itemData' => $item])
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="11" class="text-right">
                                                <button type="button" id="addNewItem" class="btn btn-sm btn-success">
                                                    <i class="fas fa-plus"></i> Add New Item
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- Total Quantity Display (Fixed as per requirement, shows Total Received Quantity) --}}
                        <div class="row mt-3">
                            <div class="col-md-3 ml-auto">
                                <div class="form-group">
                                    <label for="total_received_qty">Total Received Quantity</label>
                                    <input type="text" name="total_received_qty" id="total_received_qty" 
                                           class="form-control text-right" 
                                           value="{{ old('total_received_qty', '0.00') }}" readonly>
                                    @error('total_received_qty') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Receive Entry</button>
                    </div>
                </form>
                {{-- Form শেষ --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // 1. Select2 Initialization Function
    function initializeSelect2(selector) {
        $(selector).select2({
            placeholder: "Select a product",
            allowClear: true,
            theme: 'bootstrap4' 
        });
    }

    // 2. Row Remove Handler Function
    function removeRowHandler() {
        const rowId = $(this).data('row-id');
        $(`#${rowId}`).remove();
        updateGrandTotalQuantity(); // Row রিমুভ করার পর টোটাল আপডেট করা
    }

    // 3. Product Select Change Handler Function (Rates Fetch)
    function productSelectChangeHandler() {
        const productId = $(this).val();
        const rowId = $(this).data('id');
        
        // যদি প্রোডাক্ট সিলেক্ট করা না হয়, রেট শূন্য করে রিটার্ন করা
        if (!productId) {
            $(`.mrp-rate-${rowId}, .retail-rate-${rowId}, .distributor-rate-${rowId}, .depo-selling-price-${rowId}`).val('0.00');
            return;
        }

        // ✅ আপনার API Route টি ব্যবহার করে রেট আনা হলো
        const url = '{{ route('superadmin.api.products.rates', ':id') }}';
        const finalUrl = url.replace(':id', productId);

        $.ajax({
            url: finalUrl,
            type: 'GET',
            success: function(data) {
                // রেটগুলো অটো-ফিল করা
                $(`.mrp-rate-${rowId}`).val(parseFloat(data.mrp || 0).toFixed(2));
                $(`.retail-rate-${rowId}`).val(parseFloat(data.retail_rate || 0).toFixed(2));
                $(`.distributor-rate-${rowId}`).val(parseFloat(data.distributor_rate || 0).toFixed(2));
                $(`.depo-selling-price-${rowId}`).val(parseFloat(data.depo_selling_price || 0).toFixed(2));
            },
            error: function(xhr, status, error) {
                console.error("Error fetching product rates:", error);
            }
        });
    }
    
    // 4. Total Quantity Update Function
    function updateGrandTotalQuantity() {
        let totalQty = 0;
        
        $('.received-qty').each(function() {
            let qty = parseFloat($(this).val()) || 0;
            totalQty += qty;
        });
        
        $('#total_received_qty').val(totalQty.toFixed(2));
    }


    // 5. Add New Item Logic (Fixed)
    let itemIndex = {{ count(old('items', [0])) }}; 

    $('#addNewItem').on('click', function(e) {
        e.preventDefault();
        itemIndex++; 

        $.ajax({
            url: '{{ route('superadmin.product-receives.get-item-row') }}',
            type: 'GET',
            data: { i: itemIndex }, // নতুন Index পাঠানো হলো
            success: function(data) {
                $('#item-table-body').append(data); 
                
                // নতুন রো-এর জন্য ইভেন্ট হ্যান্ডলার সংযুক্ত করা
                initializeSelect2(`#row${itemIndex} .product-select`);
                $(`#row${itemIndex}`).find('.remove-row').on('click', removeRowHandler);
                $(`#row${itemIndex} .product-select`).on('change', productSelectChangeHandler);
                $(`#row${itemIndex} .received-qty`).on('input', updateGrandTotalQuantity);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching new item row:", error);
                alert('Failed to load new item row. Check console for details.');
                itemIndex--; 
            }
        });
    });
    
    // 6. ইনিশিয়াল লোডের জন্য এবং ইভেন্ট সংযুক্ত করা (DOM Ready)
    $(document).ready(function() {
        // প্রথম লোডে থাকা রো-এর জন্য Select2 চালু করা
        initializeSelect2('.product-select');
        
        // বিদ্যমান Row গুলোর জন্য ইভেন্ট হ্যান্ডলার সংযুক্ত করা
        $('.remove-row').on('click', removeRowHandler);
        $('.product-select').on('change', productSelectChangeHandler);
        $('.received-qty').on('input', updateGrandTotalQuantity);
        
        // যদি old data থাকে, তবে রেটগুলো ট্রিগার করা এবং টোটাল আপডেট করা
        @if(old('items'))
            $('.product-select').each(function() {
                if ($(this).val()) {
                    $(this).trigger('change');
                }
            });
            updateGrandTotalQuantity();
        @endif
        
    });
</script>
@endsection