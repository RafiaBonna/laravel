{{-- resources/views/superadmin/product_receives/create.blade.php --}}

@extends('master') 
{{-- ধরে নিলাম আপনার master layout ফাইলটি 'master.blade.php' --}}

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
                                <label for="note">Note / Remarks</label>
                                <input type="text" name="note" id="note" class="form-control" 
                                       value="{{ old('note') }}" placeholder="Any special note for this receive">
                            </div>
                        </div>
                        
                        <hr>
                        
                        {{-- Item Details Section --}}
                        <div class="row">
                            <div class="col-12">
                                <h4>Product Details</h4>
                                
                                {{-- Add New Item Button --}}
                                <button type="button" id="addNewItem" class="btn btn-sm btn-success mb-2">
                                    <i class="fas fa-plus"></i> Add New Item
                                </button>
                                
                                <table class="table table-bordered table-striped" id="productReceiveTable">
                                    <thead>
                                        <tr>
                                            <th>Product Name <span class="text-danger">*</span></th>
                                            <th style="width: 100px;">Batch No <span class="text-danger">*</span></th>
                                            <th style="width: 80px;">Qty <span class="text-danger">*</span></th>
                                            <th style="width: 80px;">MRP</th>
                                            <th style="width: 80px;">Retail</th>
                                            <th style="width: 80px;">Distributor</th>
                                            <th style="width: 80px;">Depo</th>
                                            <th style="width: 100px;">Cost Rate <span class="text-danger">*</span></th>
                                            <th style="width: 110px;">Production Date</th>
                                            <th style="width: 110px;">Expiry Date</th>
                                            <th style="width: 50px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productReceiveTableBody">
                                        {{-- Initial Row (Index 0) --}}
                                        @include('superadmin.product_receives.partials.receive_item_row', ['i' => 0, 'products' => $products])
                                    </tbody>
                                </table>
                                
                                @error('items')
                                    <div class="text-danger mt-2">At least one product item is required.</div>
                                @enderror

                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Product Receive</button>
                        <a href="{{ route('superadmin.product-receives.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // itemIndex কে 0 বা old data-র সংখ্যার থেকে শুরু করা
    let itemIndex = {{ old('items') ? count(old('items')) - 1 : 0 }};
    
    // Select2 ইনিশিয়ালাইজেশন ফাংশন (যা নতুন রো-এর জন্য ব্যবহার হবে)
    function initializeSelect2(selector) {
        $(selector).select2({
            theme: 'bootstrap4',
            placeholder: "Select Product",
            allowClear: true
        });
    }

    // 🎯 নতুন রো যোগ করার ফাংশন (মাল্টি-প্রোডাক্ট অ্যাডের জন্য)
    $('#addNewItem').on('click', function(e) {
        e.preventDefault();
        
        // 1. itemIndex বাড়ানো হলো
        itemIndex++; 

        // 2. AJAX কল করে সার্ভার থেকে রো কন্টেন্ট আনা হলো 
        $.ajax({
            url: '{{ route('superadmin.product-receives.get-item-row') }}', 
            type: 'GET',
            data: { i: itemIndex }, // নতুন রো এর Index পাঠানো হলো
            success: function(html) {
                $('#productReceiveTableBody').append(html);
                
                // 3. নতুন রো-এর জন্য Select2 ইনিশিয়ালাইজ করা
                initializeSelect2(`#row${itemIndex} .product-select`); 
            },
            error: function(xhr, status, error) {
                console.error("Error fetching item row:", error);
                alert("Could not add new item row. Please check the console.");
            }
        });
    });

    // 4. ✅ ফিক্সড ডিলিট বাটন লজিক
    $(document).on('click', '.remove-row', function(e) {
        e.preventDefault();
        // নিশ্চিত করুন অন্তত একটি রো থাকে
        if ($('#productReceiveTableBody tr').length > 1) {
             // ক্লিক করা বাটনটির নিকটতম <tr> ট্যাগটি ডিলিট করা
             $(this).closest('tr').remove();
        } else {
            alert("You must have at least one item.");
        }
    });

    // 5. রেট অটো-ফিল করার লজিক (Product Select Change Event)
    $(document).on('change', '.product-select', function() {
        const rowId = $(this).data('id'); 
        const productId = $(this).val(); 

        // রেট ফিল্ডগুলো ডিফল্ট 0.00 করা হলো
        $(`.mrp-rate-${rowId}`).val('0.00');
        $(`.retail-rate-${rowId}`).val('0.00');
        $(`.distributor-rate-${rowId}`).val('0.00');
        $(`.depo-selling-price-${rowId}`).val('0.00');

        if (productId) {
            // Route URL টি ব্যবহার করে
            const url = '{{ route('superadmin.api.products.rates', ':id') }}';
            const finalUrl = url.replace(':id', productId);

            $.ajax({
                url: finalUrl,
                type: 'GET',
                success: function(data) {
                    // রেটগুলো অটো-ফিল করা
                    $(`.mrp-rate-${rowId}`).val(parseFloat(data.mrp).toFixed(2));
                    $(`.retail-rate-${rowId}`).val(parseFloat(data.retail_rate).toFixed(2));
                    $(`.distributor-rate-${rowId}`).val(parseFloat(data.distributor_rate).toFixed(2));
                    $(`.depo-selling-price-${rowId}`).val(parseFloat(data.depo_selling_price).toFixed(2));
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching product rates:", error);
                }
            });
        }
    });
    
    // 6. ইনিশিয়াল লোডের জন্য Select2 ট্রিগার করা
    $(document).ready(function() {
        // প্রথম লোডে থাকা রো-এর জন্য Select2 চালু করা
        initializeSelect2('.product-select');
        
        // যদি old data থাকে, তবে রেটগুলো ট্রিগার করা
        @if(old('items'))
            // প্রতিটি বিদ্যমান রো-এর জন্য রেট ট্রিগার করা
            $('.product-select').each(function() {
                if ($(this).val()) {
                    $(this).trigger('change');
                }
            });
        @endif
    });
</script>
@endsection