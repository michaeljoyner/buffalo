<form action="/admin/quotes/{{ $quote->id }}" class="form-horizontal dd-form" method="POST">
    {!! csrf_field() !!}
    <div class="form-group{{ $errors->has('valid_until') ? ' has-error' : '' }}">
        <label for="valid_until">Valid until: </label>
        @if($errors->has('valid_until'))
        <span class="error-message">{{ $errors->first('valid_until') }}</span>
        @endif
        <input type="date" name="valid_until" value="{{ old('valid_until') }}" class="form-control">
    </div>
    <div class="form-group{{ $errors->has('payment_terms') ? ' has-error' : '' }}">
        <label for="payment_terms">Payment terms: </label>
        @if($errors->has('payment_terms'))
        <span class="error-message">{{ $errors->first('payment_terms') }}</span>
        @endif
        <input type="text" name="payment_terms" value="{{ old('payment_terms') }}" class="form-control">
    </div>
    <div class="form-group{{ $errors->has('remarks') ? ' has-error' : '' }}">
        <label for="remarks">Remarks: </label>
        @if($errors->has('remarks'))
        <span class="error-message">{{ $errors->first('remarks') }}</span>
        @endif
        <textarea name="remarks" class="form-control">{{ old('remarks') }}</textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn">Save Changes</button>
    </div>
</form>