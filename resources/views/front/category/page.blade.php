@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@endsection

@section('content')
    <div class="product-breadcrumbs">
        <a href="/categories" class="breadcrumb">Categories</a>
        <span class="breadcrumb">{{ $category->name }}</span>
    </div>
    <section class="page-section">
        <h1 class="h1 section-title">{{ $category->name }}</h1>
        <p class="page-position">Page <span>{{ $products->currentPage() }}</span> of <span>{{ $products->lastPage() }}</span></p>
    </section>
    <section class="category-listing-outer">
        <div class="category-menu side-menu side-panel">
            @include('front.category.mobilemenu', ['mobileCategoryItems' => $category->subcategories, 'slugBase' => '/subcategories/'])
            @include('front.category.sidemenu')
            {{--<stat-counter :step="1" stat-title="Products" :upper-val="{{ $products->total() }}"></stat-counter>--}}
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