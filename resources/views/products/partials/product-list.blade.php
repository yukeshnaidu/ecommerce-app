<div class="row">
    @foreach($products as $product)
    <div class="col-6 col-md-4 col-lg-3">
        @include('products.partials.product-card', ['product' => $product])
    </div>
    @endforeach
</div>

<div class="pagination-container">
    {{ $products->links() }}
</div>