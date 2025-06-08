@foreach($latestProducts as $product)
<div class="product-default left-details product-widget">
    <figure>
        <a href="{{ route('product.show', $product->id) }}">
            <img src="{{ asset('product_images/'.$product->image) }}" width="74" height="74" alt="{{ $product->name }}">
        </a>
    </figure>
    <div class="product-details">
        <h3 class="product-title">
            <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
        </h3>
        <div class="price-box">
            <span class="product-price">₹{{ number_format($product->price, 2) }}</span>
        </div>
    </div>
</div>
@endforeach
