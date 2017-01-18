<div class="modal fade dd-modal" id="create-supplier-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add a new Supplier</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => '/admin/suppliers', 'class' => 'form-horizontal dd-form modal-form']) !!}
                @include('errors')
                <div class="form-group">
                    <label for="name">Name: </label>
                    {!! Form::text('name', null, ['class' => "form-control", 'placeholder' => 'The factory name', 'required']) !!}
                </div>
                <div class="form-group">
                    <label for="contact_person">Contact Person: </label>
                    {!! Form::text('contact_person', null, ['class' => "form-control"]) !!}
                </div>
                <div class="form-group">
                    <label for="name">Email: </label>
                    {!! Form::email('email', null, ['class' => "form-control", 'placeholder' => 'Contact person email']) !!}
                </div>
                <div class="form-group">
                    <label for="name">Address: </label>
                    {!! Form::text('address', null, ['class' => "form-control"]) !!}
                </div>
                <div class="form-group">
                    <label for="name">Phone: </label>
                    {!! Form::text('phone', null, ['class' => "form-control"]) !!}
                </div>
                <div class="form-group">
                    <label for="name">Website: </label>
                    {!! Form::text('website', null, ['class' => "form-control", 'placeholder' => 'Must include http:// or https://']) !!}
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