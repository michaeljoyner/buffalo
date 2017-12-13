<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @section('title')
        <title>Buffalo Tools | Admin</title>
    @show
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
    <meta id="csrf-token-meta"
          name="csrf-token"
          content="{{ csrf_token() }}">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    @yield('head')
</head>
<body>
<div id="app">
    @if(Auth::check())
        @include('admin.partials.navbar')
    @endif
    <div class="container">
        @yield('content')
    </div>
        <div class="main-footer"></div>
</div>

{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>--}}
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>--}}
<script src="{{ mix('js/admin.js') }}"></script>
@include('admin.partials.flash')
@yield('bodyscripts')
</body>
</html>