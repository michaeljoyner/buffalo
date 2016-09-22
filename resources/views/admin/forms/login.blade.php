{!! Form::open(['url' => 'admin/login', 'class' => 'form-horizontal dd-form form-narrow']) !!}
<img class="login-logo-img" src="/images/buffalo_logo_small.png" alt="logo">
<h2 class="login-heading">login</h2>
@include('errors')
<div class="form-group">
    <label for="email">Email address: </label>
    <input type="email" name="email" value="{{ old('email') }}" class="form-control" autofocus tabindex="1"/>
</div>
<div class="form-group">
    <label for="password">Password: </label>
    <input type="password" name="password" class="form-control" tabindex="2"/>
</div>
<div class="form-group">
    <button id="login-submit" type="submit" class="btn dd-btn btn-red btn-wide" tabindex="3">Login</button>
</div>
{!! Form::close() !!}