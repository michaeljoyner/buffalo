<div class="modal fade dd-modal" id="create-customer-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add a new Customer</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => '/admin/customers', 'class' => 'form-horizontal dd-form modal-form']) !!}
                @include('errors')
                <div class="form-group">
                    <label for="name">Name: </label>
                    {!! Form::text('name', null, ['class' => "form-control", 'placeholder' => 'The customer/company name', 'required']) !!}
                </div>
                <div class="form-group">
                    <label for="contact_person">Contact Person: </label>
                    {!! Form::text('contact_person', null, ['class' => "form-control", 'required']) !!}
                </div>
                <div class="form-group">
                    <label for="email">Email: </label>
                    {!! Form::email('email', null, ['class' => "form-control"]) !!}
                </div>
                <div class="form-group">
                    <label for="phone">Phone: </label>
                    {!! Form::text('phone', null, ['class' => "form-control"]) !!}
                </div>
                <div class="form-group">
                    <label for="fax">Fax: </label>
                    {!! Form::text('fax', null, ['class' => "form-control"]) !!}
                </div>
                <div class="form-group">
                    <label for="website">Website: </label>
                    {!! Form::text('website', null, ['class' => "form-control"]) !!}
                </div>
                <div class="form-group">
                    <label for="address">Address: </label>
                    {!! Form::textarea('address', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="payment_terms">Payment Terms: </label>
                    {!! Form::text('payment_terms', null, ['class' => "form-control"]) !!}
                </div>
                <div class="form-group">
                    <label for="terms">Terms: </label>
                    {!! Form::text('terms', null, ['class' => "form-control"]) !!}
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