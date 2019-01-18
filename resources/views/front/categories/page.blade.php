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
        <h1 class="h1 text-white banner-quote to-right">Success through<br>quality.</h1>
    </section>
    <section class="page-section">
        <h1 class="h1 section-title">Categories</h1>
        <div class="category-index-card-container">
            @foreach($categories as $category)
                @include('front.categories.category-card', [
                    'link' => '/categories/' . $category->slug,
                    'image' => $category->imageSrc('thumb'),
                    'name' => $category->name
                ])

            @endforeach
            @include('front.categories.category-card', [
                'link' => 'https://global.buffalo-tools.com/categories',
                'image' => '/images/global/buffalo_logo_square.jpg',
                'name' => 'Buffalo Brand Tools'
            ])
        </div>
    </section>
    @include('front.partials.footer')
@endsection