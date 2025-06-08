@extends('layouts.ecom')

@section('content')
<style>
    /* Add to your CSS file */
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
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="icon-home"></i></a></li>
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
                                <a href="#" data-category-id="{{ $category->id }}" class="category-link">
                                    {{ $category->name }}
                                    <span class="category-count">({{ $category->products_count }})</span>
                                </a>
                                @if($category->subCategories->count())
                                <ul class="subcategory-list">
                                    @foreach($category->subCategories as $subCategory)
                                    <li>
                                        <a href="#" data-subcategory-id="{{ $subCategory->id }}" class="subcategory-link">
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

@push('scripts')
<script>
$(document).ready(function() {
    // Debounce function
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Initialize price slider
    const priceSlider = document.getElementById('price-slider');
    if (priceSlider) {
        noUiSlider.create(priceSlider, {
            start: [0, 1000],
            connect: true,
            range: {
                'min': 0,
                'max': 1000
            },
            step: 10
        });

        priceSlider.noUiSlider.on('update', function(values, handle) {
            document.getElementById('min-price').value = Math.round(values[0]);
            document.getElementById('max-price').value = Math.round(values[1]);
        });
    }

    // Filter products function
    function filterProducts() {
        const params = {
            category_id: $('.category-link.active').data('category-id') || null,
            sub_category_id: $('.subcategory-link.active').data('subcategory-id') || null,
            min_price: $('#min-price').val(),
            max_price: $('#max-price').val(),
            search: $('#search-input').val(),
            sort: $('#sortby').val(),
            page: $('.pagination .active span').text() || 1
        };

        $.ajax({
            url: "{{ route('products.filter') }}",
            data: params,
            success: function(response) {
                $('#products-container').html(response.products);
                $('.pagination-container').html(response.pagination);
                $('#latest-products').html(response.latestProducts);
                
                // Update showing counts
                const from = (response.current_page - 1) * response.per_page + 1;
                const to = Math.min(response.current_page * response.per_page, response.total);
                $('#showing-from').text(from);
                $('#showing-to').text(to);
                $('#total-products').text(response.total);
            }
        });
    }

    // Debounced filter
    const debouncedFilter = debounce(filterProducts, 500);

    // Event listeners
    $('#search-input').on('keyup', debouncedFilter);
    $('#sortby').on('change', filterProducts);
    $('#apply-price').on('click', filterProducts);
    
    $('.category-link').on('click', function(e) {
        e.preventDefault();
        $('.category-link').removeClass('active');
        $(this).addClass('active');
        $('.subcategory-link').removeClass('active');
        filterProducts();
    });
    
    $('.subcategory-link').on('click', function(e) {
        e.preventDefault();
        $('.subcategory-link').removeClass('active');
        $(this).addClass('active');
        filterProducts();
    });

    // Pagination links
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const page = $(this).attr('href').split('page=')[1];
        $('input[name="page"]').val(page);
        filterProducts();
    });
});
</script>
@endpush