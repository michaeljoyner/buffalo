<div class="product-index-card @if($product->isNew()) new @endif">
    <a href="/products/{{ $product->slug }}">
        <img class="product-image" src="{{ $product->imageSrc('thumb') }}" alt="{{ $product->name }}">
        <p class="h5 product-name">{{ $product->name }}</p>
    </a>
</div>