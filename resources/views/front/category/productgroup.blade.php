@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@endsection

@section('content')
    <div class="product-breadcrumbs">
        <a href="/categories" class="breadcrumb">Categories</a>
        <a href="/categories/{{ $category->slug }}" class="breadcrumb">{{ $category->name }}</a>
        <a href="/categories/{{ $productGroup->subcategory->slug }}" class="breadcrumb">{{ $productGroup->subcategory->name }}</a>
        <span class="breadcrumb">{{ $productGroup->name }}</span>
    </div>
    <section class="page-section">
        <h1 class="h1 section-title">{{ $productGroup->name }}</h1>
        <p class="page-position">Page <span>{{ $products->currentPage() }}</span> of <span>{{ $products->lastPage() }}</span></p>
    </section>
    <section class="category-listing-outer">
        <div class="category-menu side-menu side-panel">
            @include('front.category.sidemenu')
        </div>
        <div class="category-index main-panel">
            @foreach($products as $product)
                <div class="product-index-card">
                    <a href="/products/{{ $product->slug }}">
                        <img class="product-image" src="{{ $product->imageSrc('thumb') }}" alt="{{ $product->name }}">
                        <p class="h5 product-name">{{ $product->name }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
    @include('front.partials.paginator', ['paginator' => $products])
    @include('front.partials.footer')
@endsection