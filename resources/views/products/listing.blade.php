@extends('layouts.ecom')

@section('content')
<style>
   
.sidebar {
    position: sticky;
    top: 20px;
    height: 100vh;
    overflow-y: auto;
}

.widget {
    margin-bottom: 30px;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.widget-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.category-list, .subcategory-list {
    list-style: none;
    padding-left: 0;
}

.category-list > li {
    margin-bottom: 10px;
}

.subcategory-list {
    padding-left: 15px;
    margin-top: 5px;
}

.category-link, .subcategory-link {
    color: #666;
    display: block;
    padding: 5px 0;
    transition: all 0.3s;
}

.category-link:hover, 
.subcategory-link:hover,
.category-link.active, 
.subcategory-link.active {
    color: #26a;
    font-weight: 500;
}

.category-count {
    color: #999;
    font-size: 0.9em;
}

.noUi-target {
    margin: 15px 0;
}

.price-inputs {
    align-items: center;
}

#products-container {
    transition: opacity 0.3s;
}

.products-loading {
    opacity: 0.5;
    pointer-events: none;
}
</style>
<main class="main">
    <div class="container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('main') }}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3 sidebar">
                <div class="sidebar-wrapper">
                    <!-- Search Filter -->
                    <div class="widget widget-search">
                        <h3 class="widget-title">Search</h3>
                        <form id="search-form">
                            <input type="text" class="form-control" placeholder="Search products..." id="search-input">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="icon-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Category Filter -->
                    <div class="widget widget-categories">
                        <h3 class="widget-title">Categories</h3>
                        <ul class="category-list" id="category-filter">
                            @foreach($categories as $category)
                            <li>
                                <!-- <a href="#" data-category-id="{{ $category->id }}" class="category-link"> -->
                                <a href="#" 
                                    data-category-id="{{ $category->id }}" 
                                    class="category-link {{ isset($selectedCategoryId) && $selectedCategoryId == $category->id ? 'active' : '' }}">
                                    {{ $category->name }}
                                    <span class="category-count">({{ $category->products_count }})</span>
                                </a>

                                @if($category->subCategories->count())
                                <ul class="subcategory-list">
                                    @foreach($category->subCategories as $subCategory)
                                    <li>
                                        <a href="{{ route('products.filter', ['category_id' => $category->id, 'sub_category_id' => $subCategory->id]) }}"  data-subcategory-id="{{ $subCategory->id }}"
                                          class="subcategory-link {{ isset($selectedSubCategoryId) && $selectedSubCategoryId == $subCategory->id ? 'active' : '' }}">
                                            {{ $subCategory->name }}
                                        </a>

                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Price Filter -->
                    <div class="widget widget-price">
                        <h3 class="widget-title">Price Range</h3>
                        <div id="price-slider" class="mb-2"></div>
                        <div class="price-inputs d-flex">
                            <input type="number" class="form-control form-control-sm" id="min-price" placeholder="Min">
                            <span class="px-2">-</span>
                            <input type="number" class="form-control form-control-sm" id="max-price" placeholder="Max">
                            <button class="btn btn-sm btn-primary ml-2" id="apply-price">Apply</button>
                        </div>
                    </div>

                    <!-- Latest Products -->
                    <div class="widget widget-featured">
                        <h3 class="widget-title">Latest Products</h3>
                        <div class="widget-body" id="latest-products">
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 main-content">
                <div class="toolbox">
                    <div class="toolbox-left">
                        <div class="toolbox-info">
                            Showing <span id="showing-from">1</span> to <span id="showing-to">{{ $products->count() }}</span> of <span id="total-products">{{ $products->total() }}</span> Products
                        </div>
                    </div>
                    <div class="toolbox-right">
                        <div class="toolbox-sort">
                            <label for="sortby">Sort by:</label>
                            <div class="select-custom">
                                <select name="sortby" id="sortby" class="form-control">
                                    <option value="latest">Latest</option>
                                    <option value="price_asc">Price: Low to High</option>
                                    <option value="price_desc">Price: High to Low</option>
                                    <option value="name">Name</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="products-container" id="products-container">
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-6 col-md-4 col-lg-3">
                            @include('products.partials.product-card', ['product' => $product])
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="pagination-container">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let debounceTimeout;

    function loadProducts(params = {}) {
        console.log(params);
        $('#products-container').addClass('products-loading');
        $.ajax({
            url: '{{ route("products.filter") }}',
            method: 'GET',
            data: params,
            success: function(response) {
                $('#products-container').html(response.html).removeClass('products-loading');
                $('#latest-products').html(response.latestHtml);
                $('#total-products').text(response.meta.total);
                $('#showing-from').text(response.meta.from);
                $('#showing-to').text(response.meta.to);
            },
            error: function() {
                alert("Something went wrong!");
                $('#products-container').removeClass('products-loading');
            }
        });
    }

    function gatherFilters() {
        return {
            category_id: $('.category-link.active').data('category-id'),
            sub_category_id: $('.subcategory-link.active').data('subcategory-id'),
            min_price: $('#min-price').val(),
            max_price: $('#max-price').val(),
            search: $('#search-input').val(),
            sort: $('#sortby').val()
        };
    }

    // Search with debounce
    $('#search-input').on('input', function() {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            loadProducts(gatherFilters());
        }, 500);
    });

    // Sort dropdown
    $('#sortby').on('change', function() {
        loadProducts(gatherFilters());
    });

    // Price filter
    $('#apply-price').on('click', function() {
        loadProducts(gatherFilters());
    });

    // Category click
    $(document).on('click', '.category-link', function(e) {
        e.preventDefault();
        $('.category-link').removeClass('active');
        $(this).addClass('active');
        $('.subcategory-link').removeClass('active');
        loadProducts(gatherFilters());
    });

    // Subcategory click
    $(document).on('click', '.subcategory-link', function(e) {
        console.log('t');
        e.preventDefault();
        $('.subcategory-link').removeClass('active');
        $(this).addClass('active');
        loadProducts(gatherFilters());
    });

    // Pagination via AJAX
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const params = gatherFilters();
        const fullUrl = new URL(url);
        for (const key in params) {
            if (params[key]) {
                fullUrl.searchParams.set(key, params[key]);
            }
        }
        $('#products-container').addClass('products-loading');
        $.get(fullUrl.toString(), function(response) {
            $('#products-container').html(response.html).removeClass('products-loading');
            $('#latest-products').html(response.latestHtml);
            $('#total-products').text(response.meta.total);
            $('#showing-from').text(response.meta.from);
            $('#showing-to').text(response.meta.to);
        });
    });
});
</script>

@endsection