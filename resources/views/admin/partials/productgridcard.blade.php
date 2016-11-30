<div class="product-card @if($product->isNew()) new @endif">
    <a href="/admin/products/{{ $product->id }}">
        <img src="{{ $product->imageSrc('thumb') }}" alt="{{ $product->name }}">
        <h3 class="product-name">{{ $product->name }}</h3>
    </a>
</div>