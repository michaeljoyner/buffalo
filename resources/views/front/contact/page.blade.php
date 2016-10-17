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
            Please don't hesitate to contact us with any query or question you may have. We would love to get in touch and se how we can work with you.
        </p>
    </section>
    <section class="page-section contact-section full-contact-page-section">
        @include('front.home.partials.contact', ['withFooter' => false])
    </section>
    @include('front.partials.footer')
@endsection