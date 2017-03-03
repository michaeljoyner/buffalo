<form action="/admin/customers/{{ $customer->id }}" class="dd-form form-horizontal" method="POST">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-5">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Name: </label>
                @if($errors->has('name'))
                    <span class="error-message">{{ $errors->first('name') }}</span>
                @endif
                <input type="text" name="name" value="{{ old('name') ?? $customer->name }}" class="form-control" required>
            </div>
            <div class="form-group{{ $errors->has('contact_person') ? ' has-error' : '' }}">
                <label for="contact_person">Contact person: </label>
                @if($errors->has('contact_person'))
                    <span class="error-message">{{ $errors->first('contact_person') }}</span>
                @endif
                <input type="text" name="contact_person" value="{{ old('contact_person') ?? $customer->contact_person}}" class="form-control" required>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">Email: </label>
                @if($errors->has('email'))
                    <span class="error-message">{{ $errors->first('email') }}</span>
                @endif
                <input type="email" name="email" value="{{ old('email') ?? $customer->email }}" class="form-control" required>
            </div>
            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <label for="phone">Phone: </label>
                @if($errors->has('phone'))
                    <span class="error-message">{{ $errors->first('phone') }}</span>
                @endif
                <input type="text" name="phone" value="{{ old('phone') ?? $customer->phone }}" class="form-control">
            </div>
            <div class="form-group{{ $errors->has('fax') ? ' has-error' : '' }}">
                <label for="fax">Fax: </label>
                @if($errors->has('fax'))
                    <span class="error-message">{{ $errors->first('fax') }}</span>
                @endif
                <input type="text" name="fax" value="{{ old('fax') ?? $customer->fax }}" class="form-control">
            </div>
            <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                <label for="website">Website: </label>
                @if($errors->has('website'))
                    <span class="error-message">{{ $errors->first('website') }}</span>
                @endif
                <input type="text" name="website" value="{{ old('website') ?? $customer->website }}" class="form-control">
            </div>
        </div>
        <div class="col-md-offset-2 col-md-5">
            <div class="form-group{{ $errors->has('payment_terms') ? ' has-error' : '' }}">
                <label for="payment_terms">Payment terms: </label>
                @if($errors->has('payment_terms'))
                    <span class="error-message">{{ $errors->first('payment_terms') }}</span>
                @endif
                <input type="text" name="payment_terms" value="{{ old('payment_terms') ?? $customer->payment_terms }}" class="form-control">
            </div>
            <div class="form-group{{ $errors->has('terms') ? ' has-error' : '' }}">
                <label for="terms">Terms: </label>
                @if($errors->has('terms'))
                <span class="error-message">{{ $errors->first('terms') }}</span>
                @endif
                <input type="text" name="terms" value="{{ old('terms') ?? $customer->terms }}" class="form-control">
            </div>
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="address">Address: </label>
                @if($errors->has('address'))
                    <span class="error-message">{{ $errors->first('address') }}</span>
                @endif
                <textarea name="address" class="sized form-control">{{ old('address') ?? $customer->address }}</textarea>
            </div>
            <div class="form-group{{ $errors->has('remarks') ? ' has-error' : '' }}">
                <label for="remarks">Remarks: </label>
                @if($errors->has('remarks'))
                    <span class="error-message">{{ $errors->first('remarks') }}</span>
                @endif
                <textarea name="remarks" class="sized form-control">{{ old('remarks') ?? $customer->remarks }}</textarea>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn dd-btn">Save Changes</button>
    </div>
</form>