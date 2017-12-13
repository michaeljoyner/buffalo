<div class="modal fade dd-modal" id="create-supply-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add a new Supply for this Product</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => '/admin/products/' . $product->id . '/supplies', 'class' => 'form-horizontal dd-form modal-form', 'id' => 'product-supplier-form']) !!}
                @include('errors')
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="quoted_date">Quoted Date: </label>
                            <input type="date" name="quoted_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-offset-2 col-md-5">
                        <div class="form-group">
                            <label for="valid_until">Valid Until: </label>
                            <input type="date" name="valid_until" class="form-control">
                        </div>
                    </div>
                </div>
                <factory-input :factory-list='{!! json_encode($suppliers->map(function($supplier) { return ['id' => $supplier->id, 'name' => $supplier->name]; })->toArray()) !!}'
                ></factory-input>
                <div class="form-group">
                    <label for="product_code">Factory Item number: </label>
                    {!! Form::text('item_number', null, ['class' => "form-control", 'placeholder' => 'The factory item number', 'required']) !!}
                </div>
                <div class="form-group">
                    <label for="currency">Currency</label>
                    <select name="currency" id="currency_select" class="form-control">
                        <option value="TWD">New Taiwan Dollar</option>
                        <option value="USD">United States Dollar</option>
                        @foreach(config('currency_codes') as $code => $name)
                            <option value="{{ $code }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" step="0.01" name="price" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="package_price">Package Price</label>
                    <input type="number" step="0.01" name="package_price" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks: </label>
                    {!! Form::textarea('remarks', null, ['class' => "form-control", 'required']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dd-btn btn-light dd-modal-cancel-btn" data-dismiss="modal">Cancel</button>
                <button type="submit" form="product-supplier-form" class="btn dd-btn dd-modal-confirm-btn">Create</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->