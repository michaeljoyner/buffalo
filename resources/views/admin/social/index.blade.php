@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Buffalo Tools Social</h1>
    </section>
    <social-page :fb-auth="{{ $has_fb_auth ? 'true' : 'false' }}" :tw-auth="{{ $has_tw_auth ? 'true' : 'false' }}"></social-page>

@endsection