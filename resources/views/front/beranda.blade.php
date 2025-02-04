@extends('front.layouts.app')


@section('content')

<div class="page-content-wrapper">
    <!-- Search Form-->
    <!-- Search Form-->
    <div class="container">
        <div class="search-form pt-3 rtl-flex-d-row-r">
            <form action="#" method="">
                <input class="form-control" type="search" placeholder="Search in Suha">
                <button type="submit"><i class="ti ti-search"></i></button>
            </form>
            <!-- Alternative Search Options -->
            <div class="alternative-search-options">
                <div class="dropdown"><a class="btn btn-primary dropdown-toggle" id="altSearchOption" href="{{ asset('template/front') }}/#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-adjustments-horizontal"></i></a>
                    <!-- Dropdown Menu -->
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="altSearchOption">
                        <li><a class="dropdown-item" href="{{ asset('template/front') }}/#"><i class="ti ti-microphone"> </i>Voice</a></li>
                        <li><a class="dropdown-item" href="{{ asset('template/front') }}/#"><i class="ti ti-layout-collage"> </i>Image</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Wrapper -->
    <div class="hero-wrapper">
        <div class="container">
            <div class="pt-3">
                <!-- Hero Slides-->
                <div class="hero-slides owl-carousel">
                    @foreach ($data_sliders as $p)
                    <!-- Single Hero Slide-->
                    <div class="single-hero-slide" style="background-image: url('/upload/sliders/{{ $p->image }}')">
                        <div class="slide-content h-100 d-flex align-items-center">
                            <div class="slide-text">
                                <!-- <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-duration="1000ms">{{ $p->name }}</h4>
                                <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-duration="1000ms">{{ $p->description }}</p><a class="btn btn-primary" href="{{ asset('template/front') }}/#" data-animation="fadeInUp" data-delay="800ms" data-duration="1000ms">Buy Now</a> -->
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <!-- Product Catagories -->
    <div class="product-catagories-wrapper py-3">
        <div class="container">
            <div class="row g-2 rtl-flex-d-row-r">

                @foreach ($data_services as $p)
                <!-- Catagory Card -->
                <div class="col-3">
                    <div class="card catagory-card">
                        <div class="card-body px-2"><a href="{{ asset('template/front') }}/catagory.html"><img src="/upload/services/{{ $p->image }}" alt=""><span>{{ $p->name }}</span></a></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
  
    <!-- Dark Mode -->
    <div class="container">
        <div class="dark-mode-wrapper bg-img p-4 p-lg-5">
            <p class="text-white">You can change your display to a dark background using a dark mode.</p>
            <div class="form-check form-switch mb-0">
                <label class="form-check-label text-white h6 mb-0" for="darkSwitch">Pindah Mode Gelap</label>
                <input class="form-check-input" id="darkSwitch" type="checkbox" role="switch">
            </div>
        </div>
    </div>

    <div class="pb-3 pt-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Galeri</h6><a class="btn btn-sm btn-light" href="{{ asset('template/front') }}/#">
                    View all<i class="ms-1 ti ti-arrow-right"></i></a>
            </div>
            <!-- Collection Slide-->
            <div class="collection-slide owl-carousel">
                <!-- Collection Card-->
                <div class="card collection-card"><a href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/17.jpg" alt=""></a>
                    <div class="collection-title"><span>Women</span><span class="badge bg-danger">9</span></div>
                </div>
                <!-- Collection Card-->
                <div class="card collection-card"><a href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/19.jpg" alt=""></a>
                    <div class="collection-title"><span>Men</span><span class="badge bg-danger">29</span></div>
                </div>
                <!-- Collection Card-->
                <div class="card collection-card"><a href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/21.jpg" alt=""></a>
                    <div class="collection-title"><span>Kids</span><span class="badge bg-danger">4</span></div>
                </div>
                <!-- Collection Card-->
                <div class="card collection-card"><a href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/22.jpg" alt=""></a>
                    <div class="collection-title"><span>Gadget</span><span class="badge bg-danger">11</span></div>
                </div>
                <!-- Collection Card-->
                <div class="card collection-card"><a href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/23.jpg" alt=""></a>
                    <div class="collection-title"><span>Foods</span><span class="badge bg-danger">2</span></div>
                </div>
                <!-- Collection Card-->
                <div class="card collection-card"><a href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/24.jpg" alt=""></a>
                    <div class="collection-title"><span>Sports</span><span class="badge bg-danger">5</span></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Products -->
    <div class="top-products-area py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Produk Kami</h6><a class="btn btn-sm btn-light" href="{{ asset('template/front') }}/shop-grid.html">View all<i class="ms-1 ti ti-arrow-right"></i></a>
            </div>
            <div class="row g-2">
                <!-- Product Card -->
                <div class="col-6 col-md-4">
                    <div class="card product-card">
                        <div class="card-body">
                            <!-- Badge--><span class="badge rounded-pill badge-warning">Sale</span>
                            <!-- Wishlist Button--><a class="wishlist-btn" href="{{ asset('template/front') }}/#"><i class="ti ti-heart"> </i></a>
                            <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img class="mb-2" src="{{ asset('template/front') }}/img/product/11.png" alt="">
                                <!-- Offer Countdown Timer: Please use event time this format: YYYY/MM/DD hh:mm:ss -->
                                <ul class="offer-countdown-timer d-flex align-items-center shadow-sm" data-countdown="2024/12/31 23:59:59">
                                    <li><span class="days">0</span>d</li>
                                    <li><span class="hours">0</span>h</li>
                                    <li><span class="minutes">0</span>m</li>
                                    <li><span class="seconds">0</span>s</li>
                                </ul>
                            </a>
                            <!-- Product Title --><a class="product-title" href="{{ asset('template/front') }}/single-product.html">Beach Cap</a>
                            <!-- Product Price -->
                            <p class="sale-price">$13<span>$42</span></p>
                            <!-- Rating -->
                            <div class="product-rating"><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i></div>
                            <!-- Add to Cart --><a class="btn btn-primary btn-sm" href="{{ asset('template/front') }}/#"><i class="ti ti-plus"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Product Card -->
                <div class="col-6 col-md-4">
                    <div class="card product-card">
                        <div class="card-body">
                            <!-- Badge--><span class="badge rounded-pill badge-success">New</span>
                            <!-- Wishlist Button--><a class="wishlist-btn" href="{{ asset('template/front') }}/#"><i class="ti ti-heart"> </i></a>
                            <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img class="mb-2" src="{{ asset('template/front') }}/img/product/5.png" alt=""></a>
                            <!-- Product Title --><a class="product-title" href="{{ asset('template/front') }}/single-product.html">Wooden Sofa</a>
                            <!-- Product Price -->
                            <p class="sale-price">$74<span>$99</span></p>
                            <!-- Rating -->
                            <div class="product-rating"><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i></div>
                            <!-- Add to Cart --><a class="btn btn-primary btn-sm" href="{{ asset('template/front') }}/#"><i class="ti ti-plus"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Product Card -->
                <div class="col-6 col-md-4">
                    <div class="card product-card">
                        <div class="card-body">
                            <!-- Badge--><span class="badge rounded-pill badge-success">Sale</span>
                            <!-- Wishlist Button--><a class="wishlist-btn" href="{{ asset('template/front') }}/#"><i class="ti ti-heart"> </i></a>
                            <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img class="mb-2" src="{{ asset('template/front') }}/img/product/6.png" alt=""></a>
                            <!-- Product Title --><a class="product-title" href="{{ asset('template/front') }}/single-product.html">Roof Lamp</a>
                            <!-- Product Price -->
                            <p class="sale-price">$99<span>$113</span></p>
                            <!-- Rating -->
                            <div class="product-rating"><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i></div>
                            <!-- Add to Cart --><a class="btn btn-primary btn-sm" href="{{ asset('template/front') }}/#"><i class="ti ti-plus"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Product Card -->
                <div class="col-6 col-md-4">
                    <div class="card product-card">
                        <div class="card-body">
                            <!-- Badge--><span class="badge rounded-pill badge-danger">-18%</span>
                            <!-- Wishlist Button--><a class="wishlist-btn" href="{{ asset('template/front') }}/#"><i class="ti ti-heart"> </i></a>
                            <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img class="mb-2" src="{{ asset('template/front') }}/img/product/9.png" alt="">
                                <!-- Offer Countdown Timer: Please use event time this format: YYYY/MM/DD hh:mm:ss -->
                                <ul class="offer-countdown-timer d-flex align-items-center shadow-sm" data-countdown="2024/12/23 00:21:29">
                                    <li><span class="days">0</span>d</li>
                                    <li><span class="hours">0</span>h</li>
                                    <li><span class="minutes">0</span>m</li>
                                    <li><span class="seconds">0</span>s</li>
                                </ul>
                            </a>
                            <!-- Product Title --><a class="product-title" href="{{ asset('template/front') }}/single-product.html">Sneaker Shoes</a>
                            <!-- Product Price -->
                            <p class="sale-price">$87<span>$92</span></p>
                            <!-- Rating -->
                            <div class="product-rating"><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i></div>
                            <!-- Add to Cart --><a class="btn btn-primary btn-sm" href="{{ asset('template/front') }}/#"><i class="ti ti-plus"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Product Card -->
                <div class="col-6 col-md-4">
                    <div class="card product-card">
                        <div class="card-body">
                            <!-- Badge--><span class="badge rounded-pill badge-danger">-11%</span>
                            <!-- Wishlist Button--><a class="wishlist-btn" href="{{ asset('template/front') }}/#"><i class="ti ti-heart"></i></a>
                            <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img class="mb-2" src="{{ asset('template/front') }}/img/product/8.png" alt=""></a>
                            <!-- Product Title --><a class="product-title" href="{{ asset('template/front') }}/single-product.html">Wooden Chair</a>
                            <!-- Product Price -->
                            <p class="sale-price">$21<span>$25</span></p>
                            <!-- Rating -->
                            <div class="product-rating"><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i></div>
                            <!-- Add to Cart --><a class="btn btn-primary btn-sm" href="{{ asset('template/front') }}/#"><i class="ti ti-plus"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Product Card -->
                <div class="col-6 col-md-4">
                    <div class="card product-card">
                        <div class="card-body">
                            <!-- Badge--><span class="badge rounded-pill badge-warning">On Sale</span>
                            <!-- Wishlist Button--><a class="wishlist-btn" href="{{ asset('template/front') }}/#"><i class="ti ti-heart"></i></a>
                            <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img class="mb-2" src="{{ asset('template/front') }}/img/product/4.png" alt=""></a>
                            <!-- Product Title --><a class="product-title" href="{{ asset('template/front') }}/single-product.html">Polo Shirts</a>
                            <!-- Product Price -->
                            <p class="sale-price">$38<span>$41</span></p>
                            <!-- Rating -->
                            <div class="product-rating"><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i></div>
                            <!-- Add to Cart --><a class="btn btn-primary btn-sm" href="{{ asset('template/front') }}/#"><i class="ti ti-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CTA Area -->
    <div class="container">
        <div class="cta-text dir-rtl p-4 p-lg-5">
            <div class="row">
                <div class="col-9">
                    <h5 class="text-white">20% discount on women's care items.</h5><a class="btn btn-primary" href="{{ asset('template/front') }}/#">Grab this offer</a>
                </div>
            </div><img src="{{ asset('template/front') }}/img/bg-img/make-up.png" alt="">
        </div>
    </div>
    <!-- Weekly Best Sellers-->
    <div class="weekly-best-seller-area py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Weekly Best Sellers</h6><a class="btn btn-sm btn-light" href="{{ asset('template/front') }}/shop-list.html">
                    View all<i class="ms-1 ti ti-arrow-right"></i></a>
            </div>
            <div class="row g-2">
                <!-- Weekly Product Card -->
                <div class="col-12">
                    <div class="card horizontal-product-card">
                        <div class="d-flex align-items-center">
                            <div class="product-thumbnail-side">
                                <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/18.png" alt=""></a>
                                <!-- Wishlist  --><a class="wishlist-btn" href="{{ asset('template/front') }}/#"><i class="ti ti-heart"></i></a>
                            </div>
                            <div class="product-description">
                                <!-- Product Title --><a class="product-title d-block" href="{{ asset('template/front') }}/single-product.html">Nescafe Coffee Jar</a>
                                <!-- Price -->
                                <p class="sale-price"><i class="ti ti-currency-dollar"></i>$64<span>$89</span></p>
                                <!-- Rating -->
                                <div class="product-rating"><i class="ti ti-star-filled"></i>4.88 <span class="ms-1">(39 review)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Weekly Product Card -->
                <div class="col-12">
                    <div class="card horizontal-product-card">
                        <div class="d-flex align-items-center">
                            <div class="product-thumbnail-side">
                                <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/7.png" alt=""></a>
                                <!-- Wishlist  --><a class="wishlist-btn" href="{{ asset('template/front') }}/#"><i class="ti ti-heart"></i></a>
                            </div>
                            <div class="product-description">
                                <!-- Product Title --><a class="product-title d-block" href="{{ asset('template/front') }}/single-product.html">Modern Office Chair</a>
                                <!-- Price -->
                                <p class="sale-price"><i class="ti ti-currency-dollar"></i>$99<span>$159</span></p>
                                <!-- Rating -->
                                <div class="product-rating"><i class="ti ti-star-filled"></i>4.82 <span class="ms-1">(125 review)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Weekly Product Card -->
                <div class="col-12">
                    <div class="card horizontal-product-card">
                        <div class="d-flex align-items-center">
                            <div class="product-thumbnail-side">
                                <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/12.png" alt=""></a>
                                <!-- Wishlist  --><a class="wishlist-btn" href="{{ asset('template/front') }}/#"><i class="ti ti-heart"></i></a>
                            </div>
                            <div class="product-description">
                                <!-- Product Title --><a class="product-title d-block" href="{{ asset('template/front') }}/single-product.html">Beach Sunglasses</a>
                                <!-- Price -->
                                <p class="sale-price"><i class="ti ti-currency-dollar"></i>$24<span>$32</span></p>
                                <!-- Rating -->
                                <div class="product-rating"><i class="ti ti-star-filled"></i>4.79 <span class="ms-1">(63 review)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Weekly Product Card -->
                <div class="col-12">
                    <div class="card horizontal-product-card">
                        <div class="d-flex align-items-center">
                            <div class="product-thumbnail-side">
                                <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/17.png" alt=""></a>
                                <!-- Wishlist  --><a class="wishlist-btn" href="{{ asset('template/front') }}/#"><i class="ti ti-heart"></i></a>
                            </div>
                            <div class="product-description">
                                <!-- Product Title --><a class="product-title d-block" href="{{ asset('template/front') }}/single-product.html">Meow Mix Cat Food</a>
                                <!-- Price -->
                                <p class="sale-price"><i class="ti ti-currency-dollar"></i>$11.49<span>$13</span></p>
                                <!-- Rating -->
                                <div class="product-rating"><i class="ti ti-star-filled"></i>4.78 <span class="ms-1">(7 review)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Discount Coupon Card-->
    <div class="container">
        <div class="discount-coupon-card p-4 p-lg-5 dir-rtl">
            <div class="d-flex align-items-center">
                <div class="discountIcon"><img class="w-100" src="{{ asset('template/front') }}/img/core-img/discount.png" alt=""></div>
                <div class="text-content">
                    <h5 class="text-white mb-2">Get 20% discount!</h5>
                    <p class="text-white mb-0">To get discount, enter the<span class="px-1 fw-bold">GET20</span>code on the checkout page.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured Products Wrapper-->
    <div class="featured-products-wrapper py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Featured Products</h6><a class="btn btn-sm btn-light" href="{{ asset('template/front') }}/featured-products.html">View all<i class="ms-1 ti ti-arrow-right"></i></a>
            </div>
            <div class="row g-2">
                <!-- Featured Product Card-->
                <div class="col-4">
                    <div class="card featured-product-card">
                        <div class="card-body">
                            <!-- Badge--><span class="badge badge-warning custom-badge"><i class="ti ti-star-filled"></i></span>
                            <div class="product-thumbnail-side">
                                <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/14.png" alt=""></a>
                            </div>
                            <div class="product-description">
                                <!-- Product Title --><a class="product-title d-block" href="{{ asset('template/front') }}/single-product.html">Blue Skateboard</a>
                                <!-- Price -->
                                <p class="sale-price">$39<span>$89</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Featured Product Card-->
                <div class="col-4">
                    <div class="card featured-product-card">
                        <div class="card-body">
                            <!-- Badge--><span class="badge badge-warning custom-badge"><i class="ti ti-star-filled"></i></span>
                            <div class="product-thumbnail-side">
                                <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/15.png" alt=""></a>
                            </div>
                            <div class="product-description">
                                <!-- Product Title --><a class="product-title d-block" href="{{ asset('template/front') }}/single-product.html">Travel Bag</a>
                                <!-- Price -->
                                <p class="sale-price">$14.7<span>$21</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Featured Product Card-->
                <div class="col-4">
                    <div class="card featured-product-card">
                        <div class="card-body">
                            <!-- Badge--><span class="badge badge-warning custom-badge"><i class="ti ti-star-filled"></i></span>
                            <div class="product-thumbnail-side">
                                <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/16.png" alt=""></a>
                            </div>
                            <div class="product-description">
                                <!-- Product Title --><a class="product-title d-block" href="{{ asset('template/front') }}/single-product.html">Cotton T-shirts</a>
                                <!-- Price -->
                                <p class="sale-price">$3.69<span>$5</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Featured Product Card-->
                <div class="col-4">
                    <div class="card featured-product-card">
                        <div class="card-body">
                            <!-- Badge--><span class="badge badge-warning custom-badge"><i class="ti ti-star-filled"></i></span>
                            <div class="product-thumbnail-side">
                                <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/21.png" alt=""></a>
                            </div>
                            <div class="product-description">
                                <!-- Product Title --><a class="product-title d-block" href="{{ asset('template/front') }}/single-product.html">ECG Rice Cooker</a>
                                <!-- Price -->
                                <p class="sale-price">$9.33<span>$13</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Featured Product Card-->
                <div class="col-4">
                    <div class="card featured-product-card">
                        <div class="card-body">
                            <!-- Badge--><span class="badge badge-warning custom-badge"><i class="ti ti-star-filled"></i></span>
                            <div class="product-thumbnail-side">
                                <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/20.png" alt=""></a>
                            </div>
                            <div class="product-description">
                                <!-- Product Title --><a class="product-title d-block" href="{{ asset('template/front') }}/single-product.html">Beauty Cosmetics</a>
                                <!-- Price -->
                                <p class="sale-price">$5.99<span>$8</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Featured Product Card-->
                <div class="col-4">
                    <div class="card featured-product-card">
                        <div class="card-body">
                            <!-- Badge--><span class="badge badge-warning custom-badge"><i class="ti ti-star-filled"></i></span>
                            <div class="product-thumbnail-side">
                                <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ asset('template/front') }}/single-product.html"><img src="{{ asset('template/front') }}/img/product/19.png" alt=""></a>
                            </div>
                            <div class="product-description">
                                <!-- Product Title --><a class="product-title d-block" href="{{ asset('template/front') }}/single-product.html">Basketball</a>
                                <!-- Price -->
                                <p class="sale-price">$16<span>$20</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
</div>

@endsection