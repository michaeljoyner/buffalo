<div class="modal fade dd-modal" id="create-packaging-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Manage the Packaging Info</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => $formAction, 'class' => 'form-horizontal dd-form modal-form']) !!}
                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                    <label for="type">Type: </label>
                    @if($errors->has('type'))
                    <span class="error-message">{{ $errors->first('type') }}</span>
                    @endif
                    <input type="text" name="type" value="{{ old('type') ?? $packaging->type }}" class="form-control">
                </div>
                <div class="form-group{{ $errors->has('unit') ? ' has-error' : '' }}">
                    <label for="unit">Unit: </label>
                    @if($errors->has('unit'))
                    <span class="error-message">{{ $errors->first('unit') }}</span>
                    @endif
                    <input type="text" name="unit" value="{{ old('unit') ?? $packaging->unit }}" class="form-control">
                </div>
                <div class="form-group{{ $errors->has('inner') ? ' has-error' : '' }}">
                    <label for="inner">Inner: </label>
                    @if($errors->has('inner'))
                    <span class="error-message">{{ $errors->first('inner') }}</span>
                    @endif
                    <input type="number" name="inner" value="{{ old('inner') ?? $packaging->inner }}" step="1" min="1" class="form-control">
                </div>
                <div class="form-group{{ $errors->has('outer') ? ' has-error' : '' }}">
                    <label for="outer">Outer: </label>
                    @if($errors->has('outer'))
                    <span class="error-message">{{ $errors->first('outer') }}</span>
                    @endif
                    <input type="number" step="1" min="1" name="outer" value="{{ old('outer') ?? $packaging->outer }}" class="form-control">
                </div>
                <div class="form-group{{ $errors->has('carton') ? ' has-error' : '' }}">
                    <label for="carton">Carton size (cu ft): </label>
                    @if($errors->has('carton'))
                    <span class="error-message">{{ $errors->first('carton') }}</span>
                    @endif
                    <input type="text" name="carton" value="{{ old('carton') ?? $packaging->carton }}" class="form-control">
                </div>
                <div class="form-group{{ $errors->has('net_weight') ? ' has-error' : '' }}">
                    <label for="net_weight">Net weight (kg): </label>
                    @if($errors->has('net_weight'))
                    <span class="error-message">{{ $errors->first('net_weight') }}</span>
                    @endif
                    <input type="number" step="0.001" min="0" name="net_weight" value="{{ old('net_weight') ?? $packaging->net_weight }}" class="form-control">
                </div>
                <div class="form-group{{ $errors->has('gross_weight') ? ' has-error' : '' }}">
                    <label for="gross_weight">Gross weight (kg): </label>
                    @if($errors->has('gross_weight'))
                    <span class="error-message">{{ $errors->first('gross_weight') }}</span>
                    @endif
                    <input type="number" step="0.001" min="0" name="gross_weight" value="{{ old('gross_weight') ?? $packaging->gross_weight }}" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dd-btn btn-light dd-modal-cancel-btn" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn dd-btn dd-modal-confirm-btn">{{ $buttonText }}</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->