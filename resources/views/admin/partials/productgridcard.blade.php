<div class="product-card">
    <a href="/admin/products/{{ $product->id }}">
        <img src="{{ $product->imageSrc('thumb') }}" alt="{{ $product->name }}">
        <h3 class="product-name">{{ $product->name }}</h3>
    </a>
</div>