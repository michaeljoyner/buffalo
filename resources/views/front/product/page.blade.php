@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@endsection

@section('content')
    <div class="product-page-container">
        <div class="product-breadcrumbs">
            <a class="breadcrumb" href="/categories">Categories</a>
            <a class="breadcrumb" href="/categories/{{ $product->category->slug }}">{{ $product->category->name }}</a>
            @if($product->subcategory)
                <a class="breadcrumb" href="/subcategories/{{ $product->subcategory->slug }}">{{ $product->subcategory->name }}</a>
            @endif
            @if($product->productGroup)
                <a class="breadcrumb" href="/productgroups/{{ $product->productGroup->slug }}">{{ $product->productGroup->name }}</a>
            @endif
            {{--<span class="breadcrumb">{{ $product->name }}</span>--}}
        </div>
        <section class="category-breadcrumbs">

        </section>
        <section class="product-title">
            <h2 class="h2 product-title-name">{{ $product->name }}</h2>
            <h3 class="h4 text-green product-title-code">{{ $product->product_code }}</h3>
        </section>
        <section class="product-detail-outer">
            <div class="product-image-box">
                {{--<img src="{{ $product->imageSrc() }}" alt="{{ $product->name }}">--}}
                <div class="product-gallery">
                    @foreach($product->allImageUrls('web') as $index => $largeImage)
                        <img src="{{ $largeImage }}" alt="{{ $product->name }}" id="product-image-{{ $index }}" @if($loop->first) class="show" @endif>
                    @endforeach
                </div>
                @if(count($product->allImageUrls()) > 1)
                <div class="product-gallery-nav">
                    @foreach($product->allImageUrls('thumb') as $index => $thumb)
                        <a href="#product-image-{{ $index }}" data-image="product-image-{{ $index }}">
                            <img src="{{ $thumb }}" alt="{{ $product->name }}">
                        </a>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="product-details">
                <div class="product-writeup">
                    {!! $product->writeup !!}
                </div>
                <cart-button product-id="{{ $product->id }}"></cart-button>
            </div>
        </section>
        <section class="page-section related-products">
            <h1 class="h1 section-title">Related Products</h1>
            <div class="related-products-box">
                @foreach($relatedProducts as $relatedProduct)
                <div class="related-product-index-card">
                    <a href="/products/{{ $relatedProduct->slug }}">
                        <img src="{{ $relatedProduct->imageSrc('thumb') }}"
                             alt="{{ $relatedProduct->name }}"
                             class="product-image"
                        >
                        <p class="h5 product-name">{{ $relatedProduct->name }}</p>
                    </a>
                </div>
                @endforeach
            </div>
        </section>
    </div>
    @include('front.partials.footer')
@endsection

@section('bodyscripts')
    <script>
        var productGallery = {

            els: {
                imgs: null,
                links: null
            },

            init: function() {
                productGallery.els.links = Array.prototype.slice.call(document.querySelectorAll('.product-gallery-nav a'));
                productGallery.els.imgs = Array.prototype.slice.call(document.querySelectorAll('.product-gallery img'));

                productGallery.setListeners();
            },

            setListeners: function() {
                productGallery.els.links.forEach(function(link) {
                    link.addEventListener('click', productGallery.setImage, false);
                });
            },

            setImage: function(ev) {
                ev.preventDefault();
                ev.stopPropagation();
                var targetImage = ev.target.getAttribute('data-image');
                if(ev.target.tagName === 'IMG') {
                    targetImage = ev.target.parentNode.getAttribute('data-image');
                }

                productGallery.els.imgs.forEach(function(img) {
                    if(img.id === targetImage) {
                        img.classList.add('show');
                    } else {
                        img.classList.remove('show');
                    }
                });
            }
        }
        productGallery.init();
    </script>
@endsection