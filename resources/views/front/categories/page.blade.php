@extends('front.base')

@section('title')
Product Categories - Buffalo Tools
@endsection

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    @include('front.partials.ogmeta', [
        'ogTitle' => 'Product Categories - Buffalo Tools',
        'ogImage' => url('images/assets/facebook_image.jpg'),
        'ogDescription' => 'See all our product categories, including Hand Tools, Garden Tools, Auto Tools and many more.'
    ])
@endsection

@section('content')
    <section class="page-banner products-page-banner">
        <h1 class="h1 text-white banner-quote to-right">Precision<br> is an art.</h1>
    </section>
    <section class="page-section">
        <h1 class="h1 section-title">Categories</h1>
        <div class="category-index-card-container">
            @foreach($categories as $category)
            <div class="category-index-card">
                <a href="/categories/{{ $category->slug }}">
                    <img class="category-image" src="{{ $category->imageSrc('thumb') }}" alt="{{ $category->name }}">
                    <h3 class="h3 category-name @if(str_contains(strtolower($category->name), 'istone')) dark-text @endif">{{ $category->name }}</h3>
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @include('front.partials.footer')
@endsection