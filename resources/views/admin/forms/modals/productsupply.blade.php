<div class="modal fade dd-modal" id="create-supply-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add a new Supply for this Product</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => '/admin/products/' . $product->id . '/supplies', 'class' => 'form-horizontal dd-form modal-form']) !!}
                @include('errors')
                <div class="form-group">
                    <label for="quoted_date">Date: </label>
                    <input type="date" name="quoted_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="supplier_id">Supplier/Factory: </label>
                    <select name="supplier_id" id="supplier_id" class="form-control">
                        <option value="">Select a supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="product_code">Factory Item number: </label>
                    {!! Form::text('item_number', null, ['class' => "form-control", 'placeholder' => 'The factory item number', 'required']) !!}
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="package_price">Package Price</label>
                    <input type="number" name="package_price" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks: </label>
                    {!! Form::textarea('remarks', null, ['class' => "form-control", 'required']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dd-btn btn-light dd-modal-cancel-btn" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn dd-btn dd-modal-confirm-btn">Create</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->