@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@endsection

@section('content')
    <section class="page-banner contact-page-banner">
        <h1 class="h1 banner-quote to-right text-white">Reach out and touch me</h1>
    </section>
    <section class="page-section">
        <h1 class="h1 section-title">Contact Us</h1>
        <p class="strong-lead">
            I am some intro to the contact section. I introduce the contact section, what it is exactly, entice to look.
        </p>
    </section>
    <section class="page-section contact-section">
        @include('front.home.partials.contact')
    </section>
    @include('front.partials.footer')
@endsection