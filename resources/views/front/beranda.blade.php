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
            <p class="text-white">Anda bisa merubah background menjadi mode gelap.</p>
            <div class="form-check form-switch mb-0">
                <label class="form-check-label text-white h6 mb-0" for="darkSwitch">Mode Gelap</label>
                <input class="form-check-input" id="darkSwitch" type="checkbox" role="switch">
            </div>
        </div>
    </div>

    <div class="pb-3 pt-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Galeri</h6><a class="btn btn-sm btn-light" href="/">
                    Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
            </div>
            <!-- Collection Slide-->
            <div class="collection-slide owl-carousel">

                <!-- Collection Card-->
                @foreach ($data_galleries as $p)
                <div class="card collection-card"><a href="/upload/galleries/{{ $p->image }}"><img src="/upload/galleries/{{ $p->image }}" alt=""></a>
                    <div class="collection-title"><span>{{ $p->name }}</span> </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Top Products -->
    <div class="top-products-area py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Produk Kami</h6><a class="btn btn-sm btn-light" href="/l">Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
            </div>
            <div class="row g-2">
                @foreach ($data_products as $p)
                <!-- Product Card -->
                <div class="col-6 col-md-4">
                    <div class="card product-card">
                        <div class="card-body">
                            <!-- Badge-->
                            <!-- <span class="badge rounded-pill badge-warning">{{ $p->category->name ?? 'Tanpa Kategori' }}</span> -->
                            <!-- Wishlist Button-->
                            <!-- <a class="wishlist-btn" href="{{ asset('template/front') }}/#"><i class="ti ti-heart"> </i></a> -->
                            <!-- Thumbnail -->
                            <a class="product-thumbnail d-block" href="/"><img class="mb-2" src="/upload/products/{{ $p->image }}" alt="">
                                <!-- Offer Countdown Timer: Please use event time this format: YYYY/MM/DD hh:mm:ss -->
                                <!-- <ul class="offer-countdown-timer d-flex align-items-center shadow-sm" data-countdown="2024/12/31 23:59:59">
                                    <li><span class="days">0</span>d</li>
                                    <li><span class="hours">0</span>h</li>
                                    <li><span class="minutes">0</span>m</li>
                                    <li><span class="seconds">0</span>s</li>
                                </ul> -->
                            </a>
                            <a class="product-title" href="/">{{ $p->name }}</a>





                            <!-- <p class="sale-price">$13<span>$42</span></p> -->

                            <p class="sale-price-new">
                                Rp {{ number_format($p->cost_price, 0, ',', '.') }}
                                @if($p->price_before_discount && $p->price_before_discount > 0)
                                <br> <span class="old-price">Rp {{ number_format($p->price_before_discount, 0, ',', '.') }}</span>
                                @endif
                            </p>

                            <p class="custom-badge">
                                {{ $p->category->name ?? 'Tanpa Kategori' }}
                            </p>

                            <span class="product-note">
                                {{ $p->note }}
                            </span>
                            <br>




                            <!-- Rating -->
                            <!-- <div class="product-rating"><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i></div> -->
                            <!-- Add to Cart -->
                            <br>
                            <a class="btn btn-primary btn-sm" href="/"><i class="ti ti-shopping-cart"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </div>
    <!-- CTA Area -->
    <div class="container">
        <div class="cta-text dir-rtl p-4 p-lg-5">
            <div class="row">
                <div class="col-9">
                    <h5 class="text-white">Bisnis Anda Butuh Aplikasi/Website?</h5><a class="btn btn-primary" href=""><i class="ti ti-bell"></i> Hubungi Kami</a>
                </div>
            </div><img src="{{ asset('template/front') }}/img/website.png" alt="">
        </div>
    </div>
    <!-- Weekly Best Sellers-->
    <div class="weekly-best-seller-area pt-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Informasi Terbaru</h6><a class="btn btn-sm btn-light" href="{{ asset('template/front') }}/shop-list.html">
                    Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
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


    <div class="container pb-4">
        <div class="section-heading pt-3 rtl-text-right">
            <h6>Baca Berdasarkan Kategori</h6>
        </div>
        <div class="row g-2 rtl-flex-d-row-r">
            <!-- Single Catagory-->
            <div class="col-4">
                <div class="card blog-catagory-card">
                    <div class="card-body"><a href="#"> <span class="d-block">Review</span></a></div>
                </div>
            </div>
            <!-- Single Catagory-->
            <div class="col-4">
                <div class="card blog-catagory-card">
                    <div class="card-body"><a href="#"> <span class="d-block">Shopping</span></a></div>
                </div>
            </div>
            <!-- Single Catagory-->
            <div class="col-4">
                <div class="card blog-catagory-card">
                    <div class="card-body"><a href="#"> <span class="d-block">Tips</span></a></div>
                </div>
            </div>
            <!-- Single Catagory-->
            <div class="col-4">
                <div class="card blog-catagory-card">
                    <div class="card-body"><a href="#"> <span class="d-block">Offer</span></a></div>
                </div>
            </div>
            <!-- Single Catagory-->
            <div class="col-4">
                <div class="card blog-catagory-card">
                    <div class="card-body"><a href="#"> <span class="d-block">Trends</span></a></div>
                </div>
            </div>
            <!-- Single Catagory-->
            <div class="col-4">
                <div class="card blog-catagory-card">
                    <div class="card-body"><a href="#"> <span class="d-block">News</span></a></div>
                </div>
            </div>
        </div>
    </div>



    <!-- Discount Coupon Card-->
    <div class="container pb-3">
        <div class="discount-coupon-card p-4 p-lg-5 dir-rtl">
            <div class="d-flex align-items-center">
                <div class="discountIcon"><img class="w-100" src="{{ asset('template/front') }}/img/website.png" alt=""></div>
                <div class="text-content">
                    <h5 class="text-white mb-2">Hadiah Terbaik Untuk Buah Hati!</h5>
                    <p class="text-white mb-0">Media Belajar<span class="px-1 fw-bold">Anak</span>Agar Cerdas & Bahagia.</p>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection