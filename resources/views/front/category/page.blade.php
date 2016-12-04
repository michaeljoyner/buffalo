@extends('front.base')

@section('title')
{{ $category->name }} - Buffalo Tools'
@endsection

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    @include('front.partials.ogmeta', [
        'ogTitle' => $category->name .' - Buffalo Tools',
        'ogImage' => url($category->imageSrc()),
        'ogDescription' => $category->description
    ])
    <style>
        .category-page-banner-container {
            width: 100%;
            height: 16.667vw;
            background: url({{ $category->bannerSrc('large') }});
            background-size: cover;
            background-repeat: no-repeat;
            background-position-y: 33%;
        }
    </style>
@endsection

@section('content')
    {{--<div class="category-page-banner-container"></div>--}}
    <div class="product-breadcrumbs">
        <a href="/" class="breadcrumb">
            @include('svgicons.home')
        </a>
        <a href="/categories" class="breadcrumb">Categories</a>
        <span class="breadcrumb">{{ $category->name }}</span>
    </div>
    <section class="category-page-header">
        <img src="{{ $category->bannerSrc('large') }}" alt="{{ $category->name }} banner image">
        <h1 class="h1 section-title">{{ $category->name }}</h1>
    </section>
    <section class="category-listing-outer">
        @if($category->subcategories->count() > 0)
        <div class="category-menu side-menu side-panel">
            <p class="body-text no-margin-top">Browse by Category</p>
            @include('front.category.mobilemenu', ['mobileCategoryItems' => $category->subcategories, 'slugBase' => '/subcategories/'])
            @include('front.category.sidemenu')
        </div>
        @endif
        <div class="main-panel">
            <p class="no-margin-top body-text">Browse all {{ $category->name }} Products</p>
            <div class="category-index product-listing">
                @foreach($products as $product)
                    @include('front.category.productcard')
                @endforeach
            </div>
        </div>
    </section>
    <p class="page-position text-center">Page <span>{{ $products->currentPage() }}</span> of <span>{{ $products->lastPage() }}</span></p>
    @include('front.partials.paginator', ['paginator' => $products])
    @include('front.partials.footer')
@endsection