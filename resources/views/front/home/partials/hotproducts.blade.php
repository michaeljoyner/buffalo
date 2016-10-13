<h1 class="h1 section-title">Hot Products</h1>
<div class="hot-products-container">
    @foreach($products as $product)
        <div class="hot-product-card">
            <a href="/products/{{ $product->slug }}">
                <img src="{{ $product->imageSrc('thumb') }}" alt="{{ $product->name }}">
                <h3 class="h5 product-name">{{ $product->name }}</h3>
            </a>
        </div>
    @endforeach
</div>
<a href="/products" class="btn page-section-cta">See products</a>