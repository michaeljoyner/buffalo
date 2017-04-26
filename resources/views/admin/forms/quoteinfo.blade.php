<form action="/admin/quotes/{{ $quote->id }}" class="form-horizontal dd-form" method="POST">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-5">
            <div class="form-group{{ $errors->has('quote_number') ? ' has-error' : '' }}">
                <label for="quote_number">Quote number: </label>
                @if($errors->has('quote_number'))
                <span class="error-message">{{ $errors->first('quote_number') }}</span>
                @endif
                <input type="text" name="quote_number" value="{{ old('quote_number') ?? $quote->quote_number }}" class="form-control">
            </div>
            <div class="form-group{{ $errors->has('valid_until') ? ' has-error' : '' }}">
                <label for="valid_until">Valid until: </label>
                @if($errors->has('valid_until'))
                    <span class="error-message">{{ $errors->first('valid_until') }}</span>
                @endif
                <input type="date" name="valid_until" value="{{ old('valid_until') ?? $quote->valid_until ? $quote->valid_until->format('Y-m-d') : '' }}" class="form-control">
            </div>
            <div class="form-group{{ $errors->has('payment_terms') ? ' has-error' : '' }}">
                <label for="payment_terms">Payment terms: </label>
                @if($errors->has('payment_terms'))
                    <span class="error-message">{{ $errors->first('payment_terms') }}</span>
                @endif
                <input type="text" name="payment_terms" value="{{ old('payment_terms') ?? $quote->payment_terms }}" class="form-control">
            </div>
            <div class="form-group{{ $errors->has('terms') ? ' has-error' : '' }}">
                <label for="terms">Terms: </label>
                @if($errors->has('terms'))
                <span class="error-message">{{ $errors->first('terms') }}</span>
                @endif
                <input type="text" name="terms" value="{{ old('terms') ?? $quote->terms }}" class="form-control">
            </div>
            <div class="form-group{{ $errors->has('base_profit') ? ' has-error' : '' }}">
                <label for="base_profit">Base profit: </label>
                @if($errors->has('base_profit'))
                <span class="error-message">{{ $errors->first('base_profit') }}</span>
                @endif
                <input type="number" step="0.001" min="0" name="base_profit" value="{{ old('base_profit') ?? $quote->base_profit }}" class="form-control">
            </div>
            <div class="form-group{{ $errors->has('base_exchange_rate') ? ' has-error' : '' }}">
                <label for="base_exchange_rate">Base exchange rate: </label>
                @if($errors->has('base_exchange_rate'))
                <span class="error-message">{{ $errors->first('base_exchange_rate') }}</span>
                @endif
                <input type="number" step="0.001" min="0" name="base_exchange_rate" value="{{ old('base_exchange_rate') ?? $quote->base_exchange_rate }}" class="form-control">
            </div>
        </div>
        <div class="col-md-offset-2 col-md-5">
            <div class="form-group{{ $errors->has('shipment') ? ' has-error' : '' }}">
                <label for="shipment">Shipment: </label>
                @if($errors->has('shipment'))
                <span class="error-message">{{ $errors->first('shipment') }}</span>
                @endif
                <input type="text" name="shipment" value="{{ old('shipment') ?? $quote->shipment }}" class="form-control">
            </div>
            <div class="form-group{{ $errors->has('remarks') ? ' has-error' : '' }}">
                <label for="remarks">Remarks (private): </label>
                @if($errors->has('remarks'))
                    <span class="error-message">{{ $errors->first('remarks') }}</span>
                @endif
                <textarea name="remarks" class="form-control">{{ old('remarks') ?? $quote->remarks }}</textarea>
            </div>
            <div class="form-group{{ $errors->has('quotation_remarks') ? ' has-error' : '' }}">
                <label for="quotation_remarks">Quotation remarks (shown on quote): </label>
                @if($errors->has('quotation_remarks'))
                <span class="error-message">{{ $errors->first('quotation_remarks') }}</span>
                @endif
                <textarea name="quotation_remarks" class="form-control taller">{{ old('quotation_remarks') ?? $quote->quotation_remarks }}</textarea>
            </div>
        </div>
    </div>


    <div class="form-group">
        <button type="submit" class="btn dd-btn">Save Changes</button>
    </div>
</form>