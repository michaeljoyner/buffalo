@extends('front.base')

@section('title')
    {{ $subcategory->name }} - Buffalo Tools'
@endsection

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    @include('front.partials.ogmeta', [
        'ogTitle' => $subcategory->name .' - Buffalo Tools',
        'ogImage' => url($category->imageSrc()),
        'ogDescription' => $subcategory->description
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
    <div class="category-page-banner-container"></div>
    <div class="product-breadcrumbs">
        <a href="/" class="breadcrumb">
            @include('svgicons.home')
        </a>
        <a href="/categories" class="breadcrumb">Categories</a>
        <a href="/categories/{{ $category->slug }}" class="breadcrumb">{{ $category->name }}</a>
        <span class="breadcrumb">{{ $subcategory->name }}</span>
    </div>
    <section class="page-section">
        <h1 class="h1 section-title">{{ $subcategory->name }}</h1>
    </section>
    <section class="category-listing-outer">
        <div class="category-menu side-menu side-panel">
            <p class="body-text no-margin-top">Browse by Category</p>
            @include('front.category.mobilemenu', ['mobileCategoryItems' => $subcategory->productGroups, 'slugBase' => '/productgroups/'])
            @include('front.category.sidemenu')
        </div>
        <div class="main-panel">
            <p class="no-margin-top body-text">Browse all {{ $subcategory->name }} Products</p>
            <div class="category-index">
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