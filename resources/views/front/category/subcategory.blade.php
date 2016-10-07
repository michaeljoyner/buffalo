@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@endsection

@section('content')
    <section class="page-banner products-page-banner">
        <h1 class="h1 text-white banner-quote">Precision is an art</h1>
    </section>
    <section class="page-section">
        <h1 class="h1 section-title">{{ $subcategory->name }}</h1>
        <p class="page-position">Page <span>{{ $products->currentPage() }}</span> of <span>{{ $products->lastPage() }}</span></p>
    </section>
    <section class="category-listing-outer">
        <div class="category-menu side-menu side-panel">
            @include('front.category.mobilemenu', ['mobileCategoryItems' => $subcategory->productGroups, 'slugBase' => '/productgroups/'])
            <ul class="first-level">
                @foreach($subcategory->productGroups as $productGroup)
                    <li><a href="/productgroups/{{ $productGroup->slug }}">{{ $productGroup->name }}</a></li>
                @endforeach
            </ul>
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