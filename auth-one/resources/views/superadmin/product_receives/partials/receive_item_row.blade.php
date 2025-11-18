{{-- resources/views/superadmin/product_receives/partials/receive_item_row.blade.php --}}
<tr data-index="{{ $i }}">
    {{-- Product Dropdown --}}
    <td>
        {{-- ✅ FIX: form-control ক্লাস যোগ করা হলো Select2 এর স্টাইল ঠিক করার জন্য --}}
        <select name="items[{{ $i }}][product_id]" class="form-control form-control-sm select2 product-select @error("items.$i.product_id") is-invalid @enderror" required>
            <option value="">Select Product</option>
            @foreach($products as $id => $name)
                <option value="{{ $id }}" {{ old("items.$i.product_id", $oldItem['product_id'] ?? '') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
        @error("items.$i.product_id")<small class="text-danger">{{ $message }}</small>@enderror
    </td>

    {{-- Batch No --}}
    <td>
        <input type="text" name="items[{{ $i }}][batch_no]" class="form-control form-control-sm @error("items.$i.batch_no") is-invalid @enderror"
               value="{{ old("items.$i.batch_no", $oldItem['batch_no'] ?? '') }}" required>
        @error("items.$i.batch_no")<small class="text-danger">{{ $message }}</small>@enderror
    </td>

    {{-- Quantity --}}
    <td>
        <input type="number" name="items[{{ $i }}][received_quantity]" class="form-control form-control-sm text-right qty @error("items.$i.received_quantity") is-invalid @enderror"
               value="{{ old("items.$i.received_quantity", $oldItem['received_quantity'] ?? 0) }}" min="0.01" step="0.01" required>
        @error("items.$i.received_quantity")<small class="text-danger">{{ $message }}</small>@enderror
    </td>

    {{-- Cost Rate (Unit Stock) --}}
    <td>
        <input type="number" name="items[{{ $i }}][cost_rate]" class="form-control form-control-sm text-right cost-rate @error("items.$i.cost_rate") is-invalid @enderror"
               value="{{ old("items.$i.cost_rate", $oldItem['cost_rate'] ?? 0) }}" min="0" step="0.01" required>
        @error("items.$i.cost_rate")<small class="text-danger">{{ $message }}</small>@enderror
    </td>
    
    {{-- Total Item Cost (Hidden field for Calculation) --}}
    <td>
        <input type="text" name="items[{{ $i }}][total_item_cost]" class="form-control form-control-sm text-right total-cost-item bg-light"
               value="{{ old("items.$i.total_item_cost", $oldItem['total_item_cost'] ?? 0.00) }}" readonly required>
        @error("items.$i.total_item_cost")<small class="text-danger">Total Cost Required</small>@enderror
    </td>

    {{-- Expiry Date --}}
    <td>
        <input type="date" name="items[{{ $i }}][expiry_date]" class="form-control form-control-sm @error("items.$i.expiry_date") is-invalid @enderror"
               value="{{ old("items.$i.expiry_date", $oldItem['expiry_date'] ?? '') }}" required>
        @error("items.$i.expiry_date")<small class="text-danger">{{ $message }}</small>@enderror
    </td>
    
    {{-- Action Button --}}
    <td class="text-center">
        <button type="button" class="btn btn-xs btn-danger removeItemRow" title="Remove Item">
            <i class="fas fa-times"></i>
        </button>
    </td>
</tr>