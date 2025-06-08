@extends('layouts.ecom')

@section('content')

<div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-gallery">
                                <img src="{{ asset('product_images/'.$product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h1 class="product-title">{{ $product->name }}</h1>
                            
                            <div class="product-meta">
                                <span class="product-category">
                                    Category: <a href="#">{{ $product->category->name ?? 'N/A' }}</a>
                                </span>
                                @if($product->subCategory)
                                <span class="product-subcategory">
                                    Subcategory: <a href="#">{{ $product->subCategory->name }}</a>
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
                            
                            <!--  -->
                            <div class="product-action">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="quantity">
                                        <input type="number" name="quantity" value="1" min="1" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-dark btn-add-cart">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    @if($relatedProducts->count())
                    <div class="related-products mt-5">
                        <h3>Related Products</h3>
                        <div class="row">
                            @foreach($relatedProducts as $related)
                            <div class="col-md-3">
                                <div class="product-default">
                                    <figure>
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