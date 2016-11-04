@extends('front.base')

@section('title')
    {{ $productGroup->name }} - Buffalo Tools'
@endsection

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    @include('front.partials.ogmeta', [
        'ogTitle' => $productGroup->name .' - Buffalo Tools',
        'ogImage' => url($category->imageSrc()),
        'ogDescription' => $productGroup->description
    ])
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
                @include('front.category.productcard')
            @endforeach
        </div>
    </section>
    @include('front.partials.paginator', ['paginator' => $products])
    @include('front.partials.footer')
@endsection