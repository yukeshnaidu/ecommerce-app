<div class="product-default inner-quickview inner-icon">
    <figure>
        <a href="{{ route('product.show', $product->id) }}">
            <img src="{{ asset('product_images/'.$product->image) }}" 
                 style="width: 100%; height: 200px; object-fit: cover;" 
                 alt="{{ $product->name }}">
        </a>
        <div class="label-group">
            @if($product->created_at > now()->subDays(7))
                <div class="product-label label-new">NEW</div>
            @endif
        </div>
        <div class="btn-icon-group">
            <a href="#" class="btn-icon btn-add-cart product-type-simple" 
               data-product-id="{{ $product->id }}">
                <i class="icon-shopping-cart"></i>
            </a>
        </div>
    </figure>

    <div class="product-details">
        <div class="category-wrap">
            <div class="category-list">
                <a href="#" class="product-category">{{ $product->category->name }}</a>
            </div>
            <!-- <a href="#" class="btn-icon-wish"><i class="icon-heart"></i></a> -->
        </div>

        <h3 class="product-title">
            <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
        </h3>

        <!-- <div class="ratings-container">
            <div class="product-ratings">
                <span class="ratings" style="width:80%"></span>
                <span class="tooltiptext tooltip-top">4.0</span>
            </div>
        </div> -->

        <div class="price-box">
            <span class="product-price">₹{{ number_format($product->price, 2) }}</span>
        </div>
    </div>
</div>