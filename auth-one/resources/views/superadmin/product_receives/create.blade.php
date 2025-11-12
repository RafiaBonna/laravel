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
                <form action="{{ route('superadmin.product-receives.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        {{-- Header Section --}}
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="receive_no">Receive No</label>
                                <input type="text" name="receive_no" id="receive_no" class="form-control" 
                                       value="{{ old('receive_no', $nextReceiveNo) }}" readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="receive_date">Receive Date <span class="text-danger">*</span></label>
                                <input type="date" name="receive_date" id="receive_date" class="form-control @error('receive_date') is-invalid @enderror" 
                                       value="{{ old('receive_date', date('Y-m-d')) }}" required>
                                @error('receive_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="note">Note / Comment</label>
                                <textarea name="note" id="note" class="form-control">{{ old('note') }}</textarea>
                            </div>
                        </div>

                        <h4 class="mt-4 mb-3">Product Items (Multi Add)</h4>
                        
                        {{-- Items Table --}}
                        <table class="table table-bordered" id="product_items_table">
                            <thead>
                                <tr class="bg-light">
                                    <th width="30%">Product <span class="text-danger">*</span></th>
                                    <th width="15%">Batch No <span class="text-danger">*</span></th>
                                    <th width="15%">Quantity <span class="text-danger">*</span></th>
                                    <th width="15%">Production Date</th>
                                    <th width="15%">Expiry Date</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Item rows will be appended here --}}
                                @if(old('items'))
                                    {{-- If validation fails, repopulate old data --}}
                                @else
                                    @include('superadmin.product_receives.partials.receive_item_row', ['i' => 0, 'products' => $products])
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right">
                                        <button type="button" class="btn btn-success btn-sm" id="add_item_btn">
                                            <i class="fas fa-plus"></i> Add Another Product
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        @error('items') <span class="text-danger">{{ $message }}</span> @enderror
                        @error('items.*.product_id') <span class="text-danger">A product item field is invalid.</span> @enderror

                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary btn-lg">Complete Receive & Update Stock</button>
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
    let i = {{ count(old('items', [])) }};
    
    // 1. Add New Item Row
    $('#add_item_btn').click(function(){
        i++;
        let newRow = `
            <tr id="row${i}">
                <td>
                    <select name="items[${i}][product_id]" class="form-control select2 @error('items.${i}.product_id') is-invalid @enderror" required>
                        <option value="">Select Product</option>
                        @foreach($products as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="items[${i}][batch_no]" class="form-control @error('items.${i}.batch_no') is-invalid @enderror" required>
                </td>
                <td>
                    <input type="number" name="items[${i}][received_quantity]" class="form-control @error('items.${i}.received_quantity') is-invalid @enderror" min="0.01" step="any" required>
                </td>
                <td>
                    <input type="date" name="items[${i}][production_date]" class="form-control">
                </td>
                <td>
                    <input type="date" name="items[${i}][expiry_date]" class="form-control">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-item-row" data-id="${i}"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `;
        $('#product_items_table tbody').append(newRow);
        // If you are using select2 for better dropdowns, you need to re-init it here
        // $('.select2').select2(); 
    });

    // 2. Remove Item Row
    $(document).on('click', '.remove-item-row', function(){
        let rowId = $(this).data('id');
        $('#row' + rowId).remove();
    });

    // 3. Optional: Initial Select2 setup (if applicable)
    // $('.select2').select2();
});
</script>
@endpush