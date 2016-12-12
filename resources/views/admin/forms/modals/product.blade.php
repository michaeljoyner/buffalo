<div class="modal fade dd-modal" id="create-product-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add a new Product to {{ $parent->name }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => $formAction, 'class' => 'form-horizontal dd-form modal-form']) !!}
                @include('errors')
                <div class="form-group">
                    <label for="name">Name: </label>
                    {!! Form::text('name', null, ['class' => "form-control", 'placeholder' => 'The product name', 'required']) !!}
                </div>
                <div class="form-group">
                    <label for="product_code">Product Code: </label>
                    {!! Form::text('product_code', null, ['class' => "form-control", 'placeholder' => 'The product code', 'required']) !!}
                </div>
                <div class="form-group">
                    <label for="description">SEO Description: </label>
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'you can edit this later']) !!}
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