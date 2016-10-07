@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@endsection

@section('content')
    <section class="page-banner about-page-banner">
        <h1 class="h1 banner-quote to-left">Our Story</h1>
    </section>
    <section class="page-section">
        <h1 class="h1 section-title">About Buffalo Tools</h1>
        <p class="strong-lead">
            I am some intro to the about section. I introduce the service section, what it is exactly, entice to look.
        </p>
    </section>
    @include('front.partials.footer')
@endsection