{{-- resources/views/superadmin/product_receives/partials/receive_item_row.blade.php --}}

@php
    // $i একটি রো ইন্ডেক্স, সাধারণত 0
    // $products হল কন্ট্রোলার থেকে আসা প্রোডাক্টের তালিকা
    $itemData = old('items.' . $i, []);
@endphp

<tr id="row{{ $i }}" data-item-id="{{ $i }}">
    <td>
        {{-- Product Select --}}
        <select name="items[{{ $i }}][product_id]" 
                class="form-control product-select select2 @error('items.'.$i.'.product_id') is-invalid @enderror" 
                data-id="{{ $i }}" {{-- JS এ ব্যবহারের জন্য data-id --}}
                required>
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
        {{-- Batch No --}}
        <input type="text" name="items[{{ $i }}][batch_no]" class="form-control @error('items.'.$i.'.batch_no') is-invalid @enderror" 
               value="{{ $itemData['batch_no'] ?? '' }}" required placeholder="Batch No">
        @error('items.'.$i.'.batch_no') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </td>
    <td>
        {{-- Received Quantity --}}
        <input type="number" name="items[{{ $i }}][received_quantity]" 
               class="form-control text-right @error('items.'.$i.'.received_quantity') is-invalid @enderror" 
               value="{{ $itemData['received_quantity'] ?? '0.00' }}" min="0.01" step="any" required placeholder="Qty">
        @error('items.'.$i.'.received_quantity') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </td>

    {{-- Rate Display Fields (Readonly) --}}
    <td><input type="text" class="form-control form-control-sm mrp-rate-{{ $i }} text-right" value="0.00" readonly></td>
    <td><input type="text" class="form-control form-control-sm retail-rate-{{ $i }} text-right" value="0.00" readonly></td>
    <td><input type="text" class="form-control form-control-sm distributor-rate-{{ $i }} text-right" value="0.00" readonly></td>
    <td><input type="text" class="form-control form-control-sm depo-selling-price-{{ $i }} text-right" value="0.00" readonly></td>

    {{-- ✅ NEW: Cost Rate Field (Required) --}}
    <td>
        <input type="number" name="items[{{ $i }}][cost_rate]" 
               class="form-control cost-rate @error('items.'.$i.'.cost_rate') is-invalid @enderror" 
               value="{{ $itemData['cost_rate'] ?? '0.00' }}" min="0.00" step="any" required placeholder="Cost Rate">
        @error('items.'.$i.'.cost_rate') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </td>

    {{-- Production and Expiry Date --}}
    <td>
        <input type="date" name="items[{{ $i }}][production_date]" class="form-control" 
               value="{{ $itemData['production_date'] ?? '' }}">
    </td>
    <td>
        <input type="date" name="items[{{ $i }}][expiry_date]" class="form-control" 
               value="{{ $itemData['expiry_date'] ?? '' }}">
    </td>
    
    {{-- ✅ ফিক্সড অ্যাকশন বাটন --}}
    <td>
        {{-- ডিলিট বাটন (যদি রো-এর ইন্ডেক্স 0 এর বেশি হয় তবেই ডিলিট করা যাবে) --}}
        @if($i > 0)
        <button type="button" class="btn btn-danger btn-sm remove-row" title="Remove Item">
            <i class="fas fa-times"></i>
        </button>
        @else
        {{-- প্রথম রো ডিলিট করা যাবে না --}}
        <button type="button" class="btn btn-secondary btn-sm" disabled title="Cannot remove initial row">
            <i class="fas fa-ban"></i>
        </button>
        @endif
    </td>
</tr>