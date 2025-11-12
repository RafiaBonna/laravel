{{-- resources/views/superadmin/product_receives/partials/receive_item_row.blade.php --}}

@php
    // $i is the index for the item row
    // $products is the collection of available products
    $itemData = old('items.' . $i, []);
@endphp

<tr id="row{{ $i }}">
    <td>
        <select name="items[{{ $i }}][product_id]" class="form-control select2 @error('items.'.$i.'.product_id') is-invalid @enderror" required>
            <option value="">Select Product</option>
            @foreach($products as $id => $name)
                <option value="{{ $id }}" {{ (isset($itemData['product_id']) && $itemData['product_id'] == $id) ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
        @error('items.'.$i.'.product_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </td>
    <td>
        <input type="text" name="items[{{ $i }}][batch_no]" class="form-control @error('items.'.$i.'.batch_no') is-invalid @enderror" 
               value="{{ $itemData['batch_no'] ?? '' }}" required>
        @error('items.'.$i.'.batch_no') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </td>
    <td>
        <input type="number" name="items[{{ $i }}][received_quantity]" class="form-control @error('items.'.$i.'.received_quantity') is-invalid @enderror" 
               value="{{ $itemData['received_quantity'] ?? '' }}" min="0.01" step="any" required>
        @error('items.'.$i.'.received_quantity') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </td>
    <td>
        <input type="date" name="items[{{ $i }}][production_date]" class="form-control" 
               value="{{ $itemData['production_date'] ?? '' }}">
    </td>
    <td>
        <input type="date" name="items[{{ $i }}][expiry_date]" class="form-control" 
               value="{{ $itemData['expiry_date'] ?? '' }}">
    </td>
    <td>
        {{-- প্রথম রো এর জন্য ডিলিট বাটন থাকবে না --}}
        @if ($i > 0)
            <button type="button" class="btn btn-danger btn-sm remove-item-row" data-id="{{ $i }}"><i class="fas fa-trash"></i></button>
        @endif
    </td>
</tr>