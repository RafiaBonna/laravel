{{-- resources/views/superadmin/product_receives/_form.blade.php --}}
<div class="row">
    {{-- Receive No --}}
    <div class="form-group col-md-3">
        <label for="receive_no">Receive No. <span class="text-danger">*</span></label>
        <input type="text" name="receive_no" id="receive_no" class="form-control @error('receive_no') is-invalid @enderror"
               value="{{ old('receive_no', $nextReceiveNo ?? '') }}" required readonly>
        @error('receive_no')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    {{-- Receive Date --}}
    <div class="form-group col-md-3">
        <label for="receive_date">Receive Date <span class="text-danger">*</span></label>
        <input type="date" name="receive_date" id="receive_date" class="form-control @error('receive_date') is-invalid @enderror"
               value="{{ old('receive_date', date('Y-m-d')) }}" required>
        @error('receive_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    {{-- Note --}}
    <div class="form-group col-md-6">
        <label for="note">Note</label>
        <input type="text" name="note" id="note" class="form-control @error('note') is-invalid @enderror"
               value="{{ old('note') }}">
        @error('note')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered table-sm" id="receiveItemsTable">
                <thead>
                    <tr>
                        <th style="width: 25%">Product <span class="text-danger">*</span></th>
                        <th style="width: 15%">Batch No</th>
                        <th style="width: 10%">Quantity <span class="text-danger">*</span></th>
                        <th style="width: 10%">Cost Rate <span class="text-danger">*</span></th>
                        <th style="width: 15%">Total Cost</th> 
                        <th style="width: 15%">Exp. Date</th>
                        <th style="width: 10%">Action</th> 
                    </tr>
                </thead>
                <tbody id="receiveItemsTableBody">
                    {{-- Item rows will be appended here by AJAX/JS --}}
                    @if(old('items'))
                        @foreach(old('items') as $i => $item)
                            @include('superadmin.product_receives.partials.receive_item_row', [
                                'i' => $i,
                                'products' => $products,
                                'oldItem' => $item
                            ])
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right font-weight-bold">GRAND TOTAL (Cost):</td>
                        <td>
                            <input type="text" id="total_cost" name="total_cost" class="form-control form-control-sm text-right font-weight-bold bg-light" value="{{ old('total_cost', 0.00) }}" readonly required>
                        </td>
                        <td colspan="2"></td> </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="1" class="text-center">
                            <button type="button" class="btn btn-xs btn-primary" id="addItemRow" title="Add New Item">
                                <i class="fas fa-plus"></i> Add Row
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>