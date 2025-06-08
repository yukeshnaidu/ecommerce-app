<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ecommerce-app</title>
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="">
    <meta name="author" content="SW-THEMES">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/icons/favicon.png') }}">


    <script>
        WebFontConfig = {
            google: {
                families: ['Open+Sans:300,400,600,700,800', 'Poppins:300,400,500,600,700,800', 'Georgia:300,400,500,600,700,800', 'Spectral+SC:300,400,500,600,700,800']
            }
        };
        (function(d) {
            var wf = d.createElement('script'),
                s = d.scripts[0];
            wf.src = 'assets/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo39.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">
</head>

<body>
    <div class="page-wrapper">
        <header class="header">
            <div class="header-top">
                <div class="container-fluid">
                    <div class="header-left d-none d-sm-block">
                        <h4 class="mb-0">Call Us: <strong>800-123-4567</strong></h4>
                    </div>
                    <!-- End .header-left -->

                    
                    <!-- End .header-right -->
                </div>
                <!-- End .container -->
            </div>
            <!-- End .header-top -->

            <div class= "header-middle sticky-header">
                <div class="container-fluid">
                    <div class="header-left pl-0">
                        <nav class="main-nav w-100">
                            <ul class="menu">
                                <li class="active">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>                                
                                <li>
                                    <a href="{{ route('products.filter') }}">Products</a>                                  
                                </li>   
                                 <li>
                                    <a href="{{ route('orders.index') }}">My Orders</a>                                  
                                </li>                             
                            </ul>
                        </nav>
                    </div>
                    <!-- End .header-left -->
                    <div class="header-center ml-lg-auto ml-0">
                        <button class="mobile-menu-toggler text-primary mr-2" type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                        <a href="{{ route('main') }}" class="logo">
                            <img src="assets/images/logo-black.png" width="111" height="44" alt="Porto Logo">
                        </a>
                    </div>

                    <div class="header-right">
                        <div class="header-icon header-search header-search-popup header-search-category d-none d-sm-block">
                            <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                            <form action="#" method="get">
                                <div class="header-search-wrapper">
                                    <input type="search" class="form-control" name="q" id="q" placeholder="I'm searching for..." required="">
                                    <button class="btn icon-search-3 border-0" type="submit"></button>
                                </div>
                                <!-- End .header-search-wrapper -->
                            </form>
                        </div>

                        <!-- User Icon -->
                        <a href="{{ route('login') }}" class="header-icon header-user-icon" title="Login" style="font-size: 20px;">
                            <i class="icon-user-2"></i>
                            <b>
                                @if(Auth::check())
                                    {{ Auth::user()->name }}
                                @else
                                    Login
                                @endif
                            </b>
                        </a>

                        <!-- Dropdown for logged in users -->
                        @if(Auth::check())                            
                                <a class="header-icon header-user-icon" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>                            
                        @endif
                        <div class="separator"></div>

                        <span class="cart-subtotal text-right d-lg-block d-none">Shopping Cart
                            <!-- <span class="cart-price d-block font2">₹0.00</span> -->
                        </span>

                        <div class="dropdown cart-dropdown">
                            <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-cart-thick"></i>
                                <span class="cart-count badge-circle">3</span>
                            </a>

                            <div class="cart-overlay"></div>

                            <div class="dropdown-menu mobile-cart">
                                <a href="#" title="Close (Esc)" class="btn-close">×</a>

                                <div class="dropdownmenu-wrapper custom-scrollbar">
                                    <div class="dropdown-cart-header">Shopping Cart</div>
                                    <!-- End .dropdown-cart-header -->

                                    <div class="dropdown-cart-products">
                                        <div class="product">
                                            <div class="product-details">
                                                <h4 class="product-title">
                                                    <a href="demo39-product.html">Ultimate 3D Bluetooth Speaker</a>
                                                </h4>

                                                <span class="cart-product-info">
                                                    <span class="cart-product-qty">1</span> × ₹99.00
                                                </span>
                                            </div>
                                            <!-- End .product-details -->

                                            <figure class="product-image-container">
                                                <a href="demo39-product.html" class="product-image">
                                                    <img src="assets/images/products/product-1.jpg" alt="product" width="80" height="80">
                                                </a>

                                                <a href="#" class="btn-remove" title="Remove Product"><span>×</span></a>
                                            </figure>
                                        </div>
                                        <!-- End .product -->

                                        <div class="product">
                                            <div class="product-details">
                                                <h4 class="product-title">
                                                    <a href="demo39-product.html">Brown Women Casual HandBag</a>
                                                </h4>

                                                <span class="cart-product-info">
                                                    <span class="cart-product-qty">1</span> × ₹35.00
                                                </span>
                                            </div>
                                            <!-- End .product-details -->

                                            <figure class="product-image-container">
                                                <a href="demo39-product.html" class="product-image">
                                                    <img src="assets/images/products/product-2.jpg" alt="product" width="80" height="80">
                                                </a>

                                                <a href="#" class="btn-remove" title="Remove Product"><span>×</span></a>
                                            </figure>
                                        </div>
                                        <!-- End .product -->

                                        <div class="product">
                                            <div class="product-details">
                                                <h4 class="product-title">
                                                    <a href="demo39-product.html">Circled Ultimate 3D Speaker</a>
                                                </h4>

                                                <span class="cart-product-info">
                                                    <span class="cart-product-qty">1</span> × ₹35.00
                                                </span>
                                            </div>
                                            <!-- End .product-details -->

                                            <figure class="product-image-container">
                                                <a href="demo39-product.html" class="product-image">
                                                    <img src="assets/images/products/product-3.jpg" alt="product" width="80" height="80">
                                                </a>
                                                <a href="#" class="btn-remove" title="Remove Product"><span>×</span></a>
                                            </figure>
                                        </div>
                                        <!-- End .product -->
                                    </div>
                                    <!-- End .cart-product -->

                                    <div class="dropdown-cart-total">
                                        <span>SUBTOTAL:</span>

                                        <span class="cart-total-price float-right">₹134.00</span>
                                    </div>
                                    <!-- End .dropdown-cart-total -->

                                    <div class="dropdown-cart-action">
                                        <a href="cart.html" class="btn btn-gray btn-block view-cart">View
                                            Cart</a>
                                        <a href="checkout.html" class="btn btn-dark btn-block">Checkout</a>
                                    </div>
                                    <!-- End .dropdown-cart-total -->
                                </div>
                                <!-- End .dropdownmenu-wrapper -->
                            </div>
                            <!-- End .dropdown-menu -->
                        </div>
                        <!-- End .dropdown -->
                    </div>
                    <!-- End .header-right -->
                </div>
                <!-- End .container -->
            </div>
            <!-- End .header-middle -->
        </header>
        <!-- End .header -->

        <main class="main">
               @yield('content')
            <div class="home-slider slide-animate owl-carousel owl-theme dot-inside show-nav-hover custom-nav-1 mb-4 text-uppercase" data-owl-options="{
                'loop': false,
                'nav' : false,
                'responsive': {
                    '0': {
                        'dots' : true
                    },
                    '1200': {
                        'nav' : true
                    }
                }
			}">
                <div class="home-slide home-slide1 banner">
                    <img class="slide-bg" src="assets/images/demoes/demo39/slider/slide-1.jpg" width="1903" height="503" alt="slider image" style="background-color: #f4f4f4;">
                    <div class="container d-flex align-items-center">
                        <div class="banner-layer appear-animate" data-animation-name="fadeInRightShorter" data-animation-delay="150">
                            <h2 class="text-transform-none">Porto wine</h2>
                            <h3 class="text-capitalize ml-2 appear-animate" data-animation-name="fadeInRightShorter" data-animation-delay="200">2016 Cabernet Sauvignon</h3>
                            <h4 class="text-transform-none ml-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. quam lacus, et suscipit lectus porta efficitur.</h4>
                            <h5 class="d-flex ml-3">
                                <span class="text-transform-none">only</span>
                                <b class="coupon-sale-text text-white align-middle text-primary font2"><sup>₹</sup><em>39</em><sup>99</sup></b>
                            </h5>
                            <a href="demo39-shop.html" class="btn btn-lg ml-3">Shop Now</a>
                        </div>
                        <!-- End .banner-layer -->
                    </div>
                </div>
                <!-- End .home-slide -->

                <div class="home-slide home-slide2 banner banner-md-vw">
                    <img class="slide-bg" src="assets/images/demoes/demo39/slider/slide-2.jpg" width="1903" height="550" alt="slider image" style="background-color: #f4f4f4;">
                    <div class="container d-flex align-items-center">
                        <div class="banner-layer appear-animate" data-animation-name="fadeInUpShorter">
                            <h2 class="text-transform-none">Rare Wines</h2>
                            <h3 class="text-capitalize ml-2">The Top Selection</h3>
                            <h4 class="text-transform-none ml-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. quam lacus, et suscipit lectus porta efficitur.</h4>
                            <h5 class="d-flex justify-content-end ml-3 appear-animate" data-animation-name="fadeInRightShorter">
                                <span class="text-transform-none">Starting at</span>
                                <b class="coupon-sale-text text-white align-middle text-primary font2"><sup>₹</sup><em>99</em><sup>99</sup></b>
                            </h5>
                            <a href="demo39-shop.html" class="btn btn-lg ml-3">Shop Now</a>
                        </div>
                        <!-- End .banner-layer -->
                    </div>
                </div>
                <!-- End .home-slide -->
            </div>
            <!-- End .home-slider -->        

            <section class="popular-products-section appear-animate" data-animation-name="fadeInUpShorter">
                <div class="container">
                    <div class="heading">
                        <h2 class="text-uppercase">Popular Category</h2>
                    </div>

                   <div class="products-slider custom-products owl-carousel owl-theme nav-outer show-nav-hover nav-image-center" 
                        data-owl-options="{
                            'dots': false,
                            'nav': true,
                            'navText': [ '<i class=icon-arrow-forward-right>', '<i class=icon-arrow-forward-right>' ]
                        }">

                        @foreach($categories as $category)
                        <div class="product-default inner-quickview inner-icon">
                            <figure style="display: flex; justify-content: center; align-items: center; height: 205px;">
                                <!-- Replace image with icon -->
                                <i class="icon-list" style="font-size: 50px;"></i>
                            </figure>

                            <div class="product-details text-center">
                                <div class="category-wrap">
                                    <div class="category-list">
                                        <!-- Link to a category filter page if exists -->
                                        <!-- <a href="#" class="product-category">{{ $category->name }}</a> -->
                                         <a href="{{ route('products.filter', ['category_id' => $category->id]) }}" class="product-category">{{ $category->name }}</a>

                                    </div>
                                </div>

                                <h3 class="product-title">
                                    <!-- <a href="#">{{ $category->name }}</a> -->
                                     <a href="{{ route('products.filter', ['category_id' => $category->id]) }}" class="product-category">{{ $category->name }}</a>

                                </h3>

                                <!-- <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:100%"></span>
                                        <span class="tooltiptext tooltip-top"></span>
                                    </div>
                                </div> -->

                                <div class="price-box">
                                    <span class="product-price">Explore</span>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <!-- End .featured-proucts -->
                </div>
            </section>

            <section class="banner-section container">
                <div class="row">
                    <div class="col-md-8 mb-md-0 mb-2">
                        <div class="banner banner1 d-flex align-items-center flex-column flex-sm-row justify-content-center justify-content-sm-between" style="background-image: url(assets/images/demoes/demo39/banners/banner-1.jpg);">
                            <div class="content-left text-sm-right text-center appear-animate" data-animation-name="fadeInRightShorter" data-animation-delay="100">
                                <h2 class="text-white">RARE WINES</h2>
                                <h5 class="mb-sm-0 mb-2">Incredible Discounts</h5>
                            </div>
                            <div class="content-right text-right appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="200">
                                <h5 class="d-flex">
                                    <span class="text-transform-none text-white">only</span>
                                    <b class="coupon-sale-text text-white align-middle text-white font2"><sup>₹</sup><em>39</em><sup>99</sup></b>
                                </h5>
                                <a href="demo39-shop.html" class="btn btn-lg">Shop Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="banner banner2" style="background-image: url(assets/images/demoes/demo39/banners/banner-2.jpg);">
                            <div class="content-left">
                                <h2 class="appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="50">Top<span class="text-primary font2">10+</span></h2>
                                <h4 class="appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="150">Under<b class="font2">₹100</b></h4>
                                <a href="demo39-shop.html" class="btn btn-lg appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="featured-products-container mb-2 appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200" id="pro">
                <div class="container">
                    <div class="heading">
                        <h2 class="text-uppercase">Featured Products</h2>
                    </div>

                 <div class="products-slider custom-products owl-carousel owl-theme nav-outer show-nav-hover nav-image-center appear-animate" 
     data-animation-delay="500" 
     data-animation-name="fadeIn" 
     data-owl-options="{
         'dots': false,
         'nav': true
     }">

    @foreach($products as $product)
    <div class="product-default inner-quickview inner-icon">
        <figure style="width: 205px; height: 205px; overflow: hidden;">
                                <a href="{{ route('product.show', $product->id) }}">
                                    @if($product->image)
                                    <img src="{{ asset('product_images/' . $product->image) }}" 
                                        style="width: 100%; height: 100%; object-fit: cover;" 
                                        alt="{{ $product->name }}">
                                    @else
                                    <img src="{{ asset('images/placeholder.jpg') }}" 
                                        style="width: 100%; height: 100%; object-fit: cover;" 
                                        alt="No image">
                                    @endif
                                </a>
                                <div class="btn-icon-group">
                                    <a href="#" class="btn-icon btn-add-cart product-type-simple" data-product-id="{{ $product->id }}">
                                        <i class="icon-shopping-cart"></i>
                                    </a>
                                </div>
                            </figure>

        <div class="product-details">
            <div class="category-wrap">
                <div class="category-list">
                    <a href="#" class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</a>
                </div>
                <!-- <a href="#" title="Wishlist" class="btn-icon-wish"><i class="icon-heart"></i></a> -->
            </div>

            <h3 class="product-title">
                <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
            </h3>

            <!-- <div class="ratings-container">
                <div class="product-ratings">
                    <span class="ratings" style="width:100%"></span>
                    <span class="tooltiptext tooltip-top"></span>
                </div>
            </div> -->

            <div class="price-box">
                <span class="product-price">₹{{ number_format($product->price, 2) }}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>

                    <!-- End .featured-proucts -->
                </div>
            </section>

            
            <!-- End .testimonials-section -->

           
            <!-- End .row -->

         

                <div class="info-boxes-container row row-joined appear-animate" data-animation-name="fadeIn" data-animation-duration="1000" data-animation-delay="100">
                    <div class="info-box info-box-icon-left col-lg-4">
                        <i class="icon-shipping"></i>

                        <div class="info-box-content">
                            <h4>FREE SHIPPING &amp; RETURN</h4>
                            <p class="text-body">Free shipping on all orders over ₹99.</p>
                        </div>
                        <!-- End .info-box-content -->
                    </div>
                    <!-- End .info-box -->

                    <div class="info-box info-box-icon-left col-lg-4">
                        <i class="icon-money"></i>

                        <div class="info-box-content">
                            <h4>MONEY BACK GUARANTEE</h4>
                            <p class="text-body">100% money back guarantee</p>
                        </div>
                        <!-- End .info-box-content -->
                    </div>
                    <!-- End .info-box -->

                    <div class="info-box info-box-icon-left col-lg-4">
                        <i class="icon-support"></i>

                        <div class="info-box-content">
                            <h4>ONLINE SUPPORT 24/7</h4>
                            <p class="text-body">Lorem ipsum dolor sit amet.</p>
                        </div>
                        <!-- End .info-box-content -->
                    </div>
                    <!-- End .info-box -->
                </div>
                <!-- End .info-boxes-container -->

             
                <!-- End .instagram-section -->
            </div> 
        </main>
        <!-- End .main -->

        <footer class="footer font2">
            <div class="container">              
                <div class="footer-middle">
                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <div class="widget">
                                <h3 class="widget-title">CUSTOMER SERVICE</h3>
                                <div class="widget-content">
                                    <ul>
                                        <li><a href="#">Help & FAQs</a></li>
                                        <li><a href="#">Order Tracking</a></li>
                                        <li><a href="#">Shipping & Delivery</a></li>
                                        <li><a href="#">Orders History</a></li>
                                        <li><a href="#">Advanced Search</a></li>
                                        <li><a href="{{ route('login') }}">Login</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="widget">
                                <h3 class="widget-title">About Us</h3>
                                <div class="widget-content">
                                    <ul>
                                        <li><a href="about.html">About Us</a></li>
                                        <li><a href="#">Careers</a></li>
                                        <li><a href="#">Our Stores</a></li>
                                        <li><a href="#">Corporate Sales</a></li>
                                        <li><a href="#">Careers</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="widget">
                                <h3 class="widget-title">More Information</h3>
                                <div class="widget-content">
                                    <ul>
                                        <li><a href="#">Affiliates</a></li>
                                        <li><a href="#">Refer a Friend</a></li>
                                        <li><a href="#">Student Beans Offers</a></li>
                                        <li><a href="#">Gift Vouchers</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="widget">
                                <h3 class="widget-title">Social Media</h3>
                                <div class="widget-content">
                                    <div class="social-icons">
                                        <a href="#" class="social-icon social-facebook icon-facebook" target="_blank" title="Facebook"></a>
                                        <a href="#" class="social-icon social-twitter icon-twitter" target="_blank" title="Twitter"></a>
                                        <a href="#" class="social-icon social-instagram icon-instagram" target="_blank" title="Instagram"></a>
                                    </div>
                                </div>
                            </div>

                            <div class="widget widget-payment">
                                <h3 class="widget-title ls-n-10">PAYMENT METHODS</h3>

                                <div class="widget-content">
                                    <div class="payment-icons">
                                        <span class="payment-icon visa" style="background-image: url(assets/images/payments/payment-visa.svg)"></span>
                                        <span class="payment-icon paypal" style="background-image: url(assets/images/payments/payment-paypal.svg)"></span>
                                        <span class="payment-icon stripe" style="background-image: url(assets/images/payments/payment-stripe.png)"></span>
                                        <span class="payment-icon verisign" style="background-image:  url(assets/images/payments/payment-verisign.svg)"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom text-center">
                    <span class="footer-copyright"> Ecommerce-app. © 2025. All Rights Reserved</span>
                </div>
            </div>
        </footer>
        <!-- End .footer -->
    </div>
    <!-- End .page-wrapper -->

    <div class="loading-overlay">
        <div class="bounce-loader">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
        <!-- End .mobile-menu-container -->

    <div class="sticky-navbar">
        <div class="sticky-info">
            <a href="{{ route('main') }}">
                <i class="icon-home"></i>Home
            </a>
        </div>
        <div class="sticky-info">
            <a href="demo39-shop.html" class="">
                <i class="icon-bars"></i>Categories
            </a>
        </div>
        <div class="sticky-info">
            <a href="wishlist.html" class="">
                <i class="icon-wishlist-2"></i>Wishlist
            </a>
        </div>
        <div class="sticky-info">
            <a href="{{ route('login') }}" class="">
                <i class="icon-user-2"></i>Account
            </a>
        </div>
        <div class="sticky-info">
            <a href="cart.html" class="">
                <i class="icon-shopping-cart position-relative">
                    <span class="cart-count badge-circle">3</span>
                </i>Cart
            </a>
        </div>
    </div>

    <!-- End .newsletter-popup -->

    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

    <!-- Plugins JS File -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/optional/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.appear.min.js')}}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.min.js') }}"></script>
</body>


<!-- Mirrored from portotheme.com/html/porto_ecommerce/{{ route('main') }} by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 30 May 2025 07:48:22 GMT -->
</html>