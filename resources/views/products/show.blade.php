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
                                    <a href="{{ route('main') }}">Home</a>
                                </li>                                
                                <li>
                                    <a href="#">Products</a>                                  
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
             <main class="main">
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
            </main>    
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




