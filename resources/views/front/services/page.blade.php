@extends('front.base')

@section('title')
    Services - What Buffalo Tools can do for you!
@endsection

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    @include('front.partials.ogmeta', [
        'ogTitle' => 'Services - What Buffalo Tools can do for you!',
        'ogImage' => url('images/assets/facebook_image.jpg'),
        'ogDescription' => 'We pride ourselves on our ability to consistently deliver with quality when it comes to our core services of product sourcing, product customisation and logistics.'
    ])
@endsection

@section('content')
    <section class="page-banner services-page-banner">
        <h1 class="h1 banner-quote to-left">We're all about you.</h1>
    </section>
    <section class="page-section">
        <h1 class="h1 section-title">Services</h1>
        <p class="strong-lead">
            I am some intro to the services section. I introduce the service section, what it is exactly, entice to look.
        </p>
        <div class="services-container">
            <div class="service-writeup">
                @include('svgicons.service_1')
                <p class="body-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque debitis dolorum earum eveniet magni nisi quis saepe veritatis. Ab asperiores corporis deleniti itaque iure modi placeat rerum sint ut velit! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto dolorum facere incidunt.</p>
            </div>
            <div class="service-writeup">
                @include('svgicons.service_2')
                <p class="body-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto aspernatur dolorem hic illum. Facilis ipsa itaque minima necessitatibus reprehenderit? Adipisci culpa cumque eos error ipsam maiores officia, repellat tenetur. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            </div>
            <div class="service-writeup">
                @include('svgicons.service_3')
                <p class="body-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum excepturi harum pariatur quasi quia ratione reprehenderit suscipit, tempore. A cumque dicta doloremque dolores earum eius eveniet nostrum odit perferendis voluptas! Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            </div>
            <div class="service-writeup">
                @include('svgicons.service_4')
                <p class="body-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam asperiores fuga hic ipsum maxime necessitatibus obcaecati pariatur perferendis quaerat reiciendis, repellat repellendus saepe sed ullam velit? Facere fugit mollitia quos? Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            </div>
        </div>
        <section class="customers">
            <h2 class="h1 text-centered section-title">Our Customers</h2>
            <p class="strong-lead">We have exported our products to over 26 countries since 1990.</p>
            <div class="map-container">
                @include('svg.buffalo_map_1')
            </div>
            <p class="strong-lead">Some of our customers include:</p>
            <div class="customer-logos">
                <div>
                    <img src="/images/customers/client_eaton.png" alt="Eaton logo">
                    <img src="/images/customers/client_wurth.png" alt="Wurth logo">
                    <img src="/images/customers/client_berner.png" alt="Berner logo">
                </div>
                <div>
                    <img src="/images/customers/client_d2.png" alt="D2 logo">
                    <img src="/images/customers/client_apex.png" alt="Apex logo">
                    <img src="/images/customers/client_ustape.png" alt="US Tape logo">
                </div>
            </div>
        </section>
    </section>
    @include('front.partials.footer')
@endsection