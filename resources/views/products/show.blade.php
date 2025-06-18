@extends('layouts.ecom')

@section('content')
<style>
    .product-breadcrumb
    {
        font-size: 1.8rem;
    }
</style>
<div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-gallery" style="width: 350px; height: 350px; overflow: hidden;">
                                <img src="{{ asset('product_images/'.$product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h1 class="product-title">{{ $product->name }}</h1>
                            
                            <div class="product-meta">
                                @if($product->subCategory)
                                    <span class="product-breadcrumb">
                                        <a href="#">{{ $product->category->name ?? 'N/A' }}</a>
                                        @foreach($product->subCategory->ancestors() as $ancestor)
                                           > <a href="#">{{ $ancestor->name }}</a>
                                        @endforeach
                                        > <a href="#">{{ $product->subCategory->name }}</a>
                                    </span>
                                @else
                                    <span class="product-category">
                                        Category: <a href="#">{{ $product->category->name ?? 'N/A' }}</a>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="product-price">
                                <span class="price">₹{{ number_format($product->price, 2) }}</span>
                            </div>
                            
                            <div class="product-details">
                                <h3>Description</h3>
                                <div class="product-description">
                                    {!! $product->description !!}
                                </div>
                            </div>
                            
                            <!-- add to cart option   -->
                            
                        </div>
                    </div>
                    
                    @if($relatedProducts->count())
                    <div class="related-products mt-5">
                        <h3>Related Products</h3>
                        <div class="row">
                            @foreach($relatedProducts as $related)
                            <div class="col-md-3">
                                <div class="product-default">
                                    <figure style="width: 205px; height: 205px; overflow: hidden;">
                                        <a href="{{ route('product.show', $related->id) }}">
                                            <img src="{{ asset('product_images/'.$related->image) }}" width="205" height="205" alt="{{ $related->name }}">
                                        </a>
                                    </figure>
                                    <div class="product-details">
                                        <h3 class="product-title">
                                            <a href="{{ route('product.show', $related->id) }}">{{ $related->name }}</a>
                                        </h3>
                                        <div class="price-box">
                                            <span class="product-price">₹{{ number_format($related->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
@endsection