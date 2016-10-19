<form class="form-horizontal dd-form" role="form" method="POST" action="/admin/users/register">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @include('errors')
    <div class="form-group">
        <label class="col-md-3 control-label">Name</label>
        <div class="col-md-9">
            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">E-Mail Address</label>
        <div class="col-md-9">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">Password</label>
        <div class="col-md-9">
            <input type="password" class="form-control" name="password">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">Confirm Password</label>
        <div class="col-md-9">
            <input type="password" class="form-control" name="password_confirmation">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label" for="">What privileges should the user have?</label>
        <div class="col-md-9">
            <label for="limited">
                Limited privileges
                <input id="limited" type="radio" name="privileges" value="limited" checked>
            </label><br>
            <label for="all">
                All privileges (super admin)
                <input id="all" type="radio" name="privileges" value="all">
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-9 col-md-offset-3">
            <button type="submit" class="btn dd-btn form-control">
                Register User
            </button>
        </div>
    </div>
</form>