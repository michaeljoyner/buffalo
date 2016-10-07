@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@endsection

@section('content')
<section class="hero-section page-section">
    @include('front.home.partials.carousel')
</section>
<section class="page-section about-section">
    @include('front.home.partials.about')
</section>
<section class="page-section services-section dark-section">
    @include('front.home.partials.services')
</section>
<section class="page-section hot-products-section">
    @include('front.home.partials.hotproducts')
</section>
<section class="page-section news-section dark-section">
    @include('front.home.partials.news')
</section>
<section class="page-section contact-section">
    @include('front.home.partials.contact')
    @include('front.home.partials.footer')
</section>
@endsection