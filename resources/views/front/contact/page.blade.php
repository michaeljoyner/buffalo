@extends('front.base')

@section('title')
    Contact Us - How you can get in touch with Buffalo Tools
@endsection

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    @include('front.partials.ogmeta', [
        'ogTitle' => 'Contact Us - How you can get in touch with Buffalo Tools',
        'ogImage' => '',
        'ogDescription' => 'Here you can find information on how you can get in touch with us, whether by email, message or phone.'
    ])
@endsection

@section('content')
    <section class="page-banner contact-page-banner">
        <h1 class="h1 banner-quote to-left">Let's connect.</h1>
    </section>
    <section class="page-section">
        <h1 class="h1 section-title">Contact Us</h1>
        <p class="strong-lead">
            Please don't hesitate to contact us with any query or question you may have. We would love to get in touch and see how we can work with you.
        </p>
    </section>
    <section class="page-section contact-section full-contact-page-section">
        @include('front.home.partials.contact', ['withFooter' => false])
    </section>
    <section class="contact-page-distributors">
        <h3 class="h1 section-title text-centered">Become a distributor</h3>
        <p class="text-centered">Join the Buffalo team and increase your market share and guarantee the growth of your company!</p>
        <a class="btn page-section-cta" href="https://global.buffalo-tools.com/distributors">Find out more</a>
    </section>
    @include('front.partials.footer')
@endsection