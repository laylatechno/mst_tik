@extends('front.layouts.app')


@section('content')

<div class="page-content-wrapper">
    <!-- Search Form-->
    <!-- Search Form-->

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

    <!-- Dark Mode -->
    <div class="container pt-3">
        <div class="dark-mode-wrapper bg-img p-4 p-lg-5">
            <p class="text-white">Anda bisa merubah tema menjadi mode gelap.</p>
            <div class="form-check form-switch mb-0">
                <label class="form-check-label text-white h6 mb-0" for="darkSwitch">Mode Gelap</label>
                <input class="form-check-input" id="darkSwitch" type="checkbox" role="switch">
            </div>
        </div>
    </div>


    <!-- Product Catagories -->
    <!-- <div class="product-catagories-wrapper py-3">
        <div class="container">
            <div class="row g-2 rtl-flex-d-row-r">

                @foreach ($data_services as $p)
                <div class="col-3">
                    <div class="card catagory-card">
                        <div class="card-body px-2"><a href="{{ asset('template/front') }}/catagory.html"><img src="/upload/services/{{ $p->image }}" alt=""><span>{{ $p->name }}</span></a></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div> -->




    <div class="pb-3 pt-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Kategori</h6><a class="btn btn-sm btn-light" href="/">
                    Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
            </div>
            <!-- Collection Slide-->
            <div class="collection-slide owl-carousel">
                @foreach ($data_product_categories as $p)
                <div class="card collection-card">
                    <a href="{{ url('produk?category=' . $p->slug) }}">

                        <img src="{{ $p->image ? '/upload/product_categories/' . $p->image : 'https://png.pngtree.com/png-clipart/20220124/original/pngtree-3d-camera-realistic-icon-png-image_7180126.png' }}" alt="{{ $p->name }}">
                    </a>
                    <div class="collection-title">
                        <span>{{ $p->name }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container">
        <div class="search-form pt-3 rtl-flex-d-row-r">
            <form action="{{ route('product') }}" method="GET">
                <input class="form-control" type="search" name="search" placeholder="Cari produk.." value="{{ request('search') }}">
                <button type="submit"><i class="ti ti-search"></i></button>
            </form>
            <div class="alternative-search-options">
                <div class="dropdown">
                    <a class="btn btn-primary dropdown-toggle" id="altSearchOption" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ti ti-adjustments-horizontal"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="altSearchOption">
                        <li><a class="dropdown-item" href="{{ route('product', ['search' => request('search'), 'sort' => 'termurah']) }}"><i class="ti ti-check"></i> Termurah</a></li>
                        <li><a class="dropdown-item" href="{{ route('product', ['search' => request('search'), 'sort' => 'termahal']) }}"><i class="ti ti-check"></i> Termahal</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>



    <!-- Top Products -->
    <div class="top-products-area py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Produk Pilihan</h6><a class="btn btn-sm btn-light" href="/product">Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
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
                            <a class="product-thumbnail d-block" href="{{ route('product.product_detail', $p->slug) }}">
                                <img class="mb-2" src="/upload/products/{{ $p->image }}" alt="">
                            </a>
                            <!-- Offer Countdown Timer: Please use event time this format: YYYY/MM/DD hh:mm:ss -->
                            <!-- <ul class="offer-countdown-timer d-flex align-items-center shadow-sm" data-countdown="2024/12/31 23:59:59">
                                    <li><span class="days">0</span>d</li>
                                    <li><span class="hours">0</span>h</li>
                                    <li><span class="minutes">0</span>m</li>
                                    <li><span class="seconds">0</span>s</li>
                                </ul> -->
                            </a>
                            <a class="store-badge" href="{{ url('produk?category=' . $p->category->slug) }}">
                                {{ $p->category->name ?? 'Tanpa Kategori' }}
                            </a>

                            <a class="product-title" href="{{ route('product.product_detail', $p->slug) }}">
                                {{ $p->name }}
                            </a>





                            <!-- <p class="sale-price">$13<span>$42</span></p> -->

                            <p class="sale-price-new">
                                Rp {{ number_format($p->cost_price, 0, ',', '.') }}
                                @if($p->price_before_discount && $p->price_before_discount > 0)
                                <br> <span class="old-price">Rp {{ number_format($p->price_before_discount, 0, ',', '.') }}</span>
                                @endif
                            </p>

                            <a href="">
                                <p class="custom-badge">{{ $p->user->user }} </p>
                            </a>

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


    <div class="container py-3">
        <div class="row gy-3">
            <div class="col-12">
                <!-- Single Vendor -->
                <div class="single-vendor-wrap bg-img p-4 bg-overlay" style="background-image: url('img/bg-img/12.jpg')">
                    <h6 class="vendor-title text-white">Designing World</h6>
                    <div class="vendor-info">
                        <p class="mb-1 text-white"><i class="ti ti-map-pin me-1"></i>Dhaka, Bangladesh</p>
                        <div class="ratings lh-1"><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><span class="text-white">(99% Positive Seller)</span></div>
                    </div><a class="btn btn-primary btn-sm mt-3" href="vendor-shop.html">Go to store<i class="ti ti-arrow-right ms-1"></i></a>
                    <!-- Vendor Profile-->
                    <div class="vendor-profile shadow">
                        <figure class="m-0"><img src="img/product/dw.png" alt=""></figure>
                    </div>
                </div>
            </div>

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
                                <!-- Thumbnail --><a class="product-thumbnail d-block" href="/"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSBD45WUjQ8nbq7R5tVVNmjkcbtIX35pmK8irjGOenMkkADVGhBFir7AbrdP4g50aOfQx0&usqp=CAU" alt=""></a>
                            </div>
                            <div class="product-description py-2">
                                <!-- Product Title --><a class="product-title d-block" href="/">Tips Hidup Sehat Dengan Metode IF</a>
                               
                               
                                 <p>
                                 Yasir <span class="ms-1"> - 28 Desember 2025 </span> 
                                 </p>
                                 <p class="sale-price"><i class="ti ti-tag"></i>Olahraga</p>
                            </div>
                        </div>
                    </div>
                </div>
                 
            </div>
        </div>
    </div>


    

    <!-- Discount Coupon Card-->
    <div class="container py-3">
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

    <div class="top-products-area py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Produk Promo</h6><a class="btn btn-sm btn-light" href="/l">Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
            </div>
            <div class="row g-2">
                @foreach ($product_discount as $p)
                <!-- Product Card -->
                <div class="col-6 col-md-4">
                    <div class="card product-card">
                        <div class="card-body">

                            <a class="product-thumbnail d-block" href="/"><img class="mb-2" src="/upload/products/{{ $p->image }}" alt="">
                            </a>
                            <a class="product-title" href="/">{{ $p->name }}</a>

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
                            <br><br>
                            <a class="btn btn-primary btn-sm" href="/"><i class="ti ti-shopping-cart"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </div>

    <div class="top-products-area py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Kategori {{ $first_category->name }}</h6><a class="btn btn-sm btn-light" href="/l">Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
            </div>
            <div class="row g-2">
                @foreach ($product_first_category as $p)
                <!-- Product Card -->
                <div class="col-6 col-md-4">
                    <div class="card product-card">
                        <div class="card-body">

                            <a class="product-thumbnail d-block" href="/"><img class="mb-2" src="/upload/products/{{ $p->image }}" alt="">
                            </a>
                            <a class="product-title" href="/">{{ $p->name }}</a>

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
                            <br><br>
                            <a class="btn btn-primary btn-sm" href="/"><i class="ti ti-shopping-cart"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </div>


    <div class="top-products-area py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Kategori {{ $second_category->name }}</h6><a class="btn btn-sm btn-light" href="/l">Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
            </div>
            <div class="row g-2">
                @foreach ($product_second_category as $p)
                <!-- Product Card -->
                <div class="col-6 col-md-4">
                    <div class="card product-card">
                        <div class="card-body">

                            <a class="product-thumbnail d-block" href="/"><img class="mb-2" src="/upload/products/{{ $p->image }}" alt="">
                            </a>
                            <a class="product-title" href="/">{{ $p->name }}</a>

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
                            <br><br>
                            <a class="btn btn-primary btn-sm" href="/"><i class="ti ti-shopping-cart"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </div>


    <div class="top-products-area py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Kategori {{ $third_category->name }}</h6><a class="btn btn-sm btn-light" href="/l">Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
            </div>
            <div class="row g-2">
                @foreach ($product_third_category as $p)
                <!-- Product Card -->
                <div class="col-6 col-md-4">
                    <div class="card product-card">
                        <div class="card-body">

                            <a class="product-thumbnail d-block" href="/"><img class="mb-2" src="/upload/products/{{ $p->image }}" alt="">
                            </a>
                            <a class="product-title" href="/">{{ $p->name }}</a>

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
                            <br><br>
                            <a class="btn btn-primary btn-sm" href="/"><i class="ti ti-shopping-cart"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </div>


</div>

@endsection