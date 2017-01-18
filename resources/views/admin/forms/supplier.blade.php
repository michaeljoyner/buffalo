{!! Form::model($supplier, ['url' => '/admin/suppliers/' . $supplier->id, 'class' => 'dd-form form-horizontal']) !!}
@include('errors')
<div class="form-group">
    <label for="name">Name: </label>
    {!! Form::text('name', null, ['class' => "form-control", 'required']) !!}
</div>
<div class="form-group">
    <label for="contact_person">Contact Person: </label>
    {!! Form::text('contact_person', null, ['class' => "form-control"]) !!}
</div>
<div class="form-group">
    <label for="email">Email: </label>
    {!! Form::email('email', null, ['class' => "form-control"]) !!}
</div>
<div class="form-group">
    <label for="address">Address: </label>
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="phone">Phone: </label>
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="website">Website: </label>
    {!! Form::text('website', null, ['class' => 'form-control', 'placeholder' => 'Must include http:// or https://']) !!}
</div>
<div class="form-group">
    <button type="submit" class="btn dd-btn">Save Changes</button>
</div>
{!! Form::close() !!}