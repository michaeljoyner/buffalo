{!! Form::model($product, ['url' => '/admin/products/'.$product->id, 'class' => 'dd-form form-horizontal']) !!}
<div class="form-group">
    <label for="name">Name: </label>
    {!! Form::text('name', null, ['class' => "form-control"]) !!}
</div>
<div class="form-group">
    <label for="product_code">Product Code: </label>
    {!! Form::text('product_code', null, ['class' => "form-control"]) !!}
</div>
<div class="form-group">
    <label for="description">SEO Description: </label>
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="writeup">Writeup: </label>
    {!! Form::textarea('writeup', null, ['class' => 'form-control', 'id' => 'writeup']) !!}
</div>
<div class="form-group">
    <label for="product_note">Notes (private): </label>
    <textarea name="product_note" class="form-control taller">{{ old('product_note') ?? $product->getNote() }}</textarea>
</div>
<div class="form-group">
    <button type="submit" class="btn dd-btn">Save Changes</button>
</div>
{!! Form::close() !!}