<tr>
    <td>
        <select name="product_id[]" class="form-control">
            @foreach($products as $prod)
                <option value="{{ $prod->id }}">{{ $prod->name }}</option>
            @endforeach
        </select>
    </td>

    <td><input type="number" name="quantity[]" class="form-control qty" oninput="calculate(this)" required></td>

    <td><input type="number" name="rate[]" class="form-control rate" oninput="calculate(this)" required></td>

    <td><input type="number" class="form-control subtotal" readonly></td>

    <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()">X</button></td>
</tr>
