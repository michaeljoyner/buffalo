@extends('front.base')

@section('title')
    Buffalo Tools | Professional Hand Tools, Garden Tools, Auto Tools, Hardware Tools & OEM Supplies
@endsection

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    @include('front.partials.ogmeta', [
        'ogTitle' => 'Buffalo Tools - The home of Buffalo Tools',
        'ogImage' => url('images/assets/facebook_image.jpg'),
        'ogDescription' => 'Huang Buffalo Co., Ltd. has specialized in exporting professional hardware, DIY hand tools and OEM products to Europe, America and Asia area for more than 20 years. We are proud of our wide products range, competitive prices and high quality products.'
    ])
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
    @include('front.home.partials.contact', ['withFooter' => true])
    @include('front.home.partials.footer')
</section>
@endsection