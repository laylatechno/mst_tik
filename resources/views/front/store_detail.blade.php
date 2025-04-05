@extends('front.layouts.app')
<meta property="og:title" content="{{ $title }} - {{ $data_stores->name }}">
<meta property="og:description" content="{{ $data_stores->description }}">
<meta property="og:image" content="{{ asset('upload/users/' . $data_stores->image) }}">
<meta property="og:url" content="{{ request()->fullUrl() }}">
<meta property="og:type" content="website">
<style>
    .video-container {
        position: relative;
        width: 100%;
        /* Full width sesuai container */
        padding-top: 56.25%;
        /* Rasio 16:9 */
        overflow: hidden;
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>



@section('content')
    <div class="page-content-wrapper">


        <div class="header-area" id="headerArea">
            <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
                <!-- Back Button-->
                <div class="back-button me-2"><a href="/"><i class="ti ti-arrow-left"></i></a></div>
                <!-- Page Title-->
                <div class="page-heading">
                    <h6 class="mb-0">{{ $subtitle }}</h6>
                </div>
                <!-- Navbar Toggler-->
                <div class="suha-navbar-toggler ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas"
                    aria-controls="suhaOffcanvas">
                    <div><span></span><span></span><span></span></div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="page-content-wrapper pb-3">
                <!-- Vendor Details Wrap -->
                <div class="vendor-details-wrap bg-img bg-overlay py-4"
                    style="background-image: url('/upload/users/{{ $data_stores->banner }}')">
                    <div class="container">
                        <div class="d-flex align-items-start">
                            <!-- Vendor Profile-->
                            <div class="vendor-profile shadow me-3">
                                <figure class="m-0"><img src="/upload/users/{{ $data_stores->image }}" alt="">
                                </figure>
                            </div>
                            <!-- Vendor Info-->
                            <div class="vendor-info">
                                <p class="mb-1 text-white"><i class="ti ti-briefcase me-1"></i>{{ $data_stores->about }}</p>
                                <p class="mb-1 text-white"><i class="ti ti-map-pin me-1"></i>{{ $data_stores->address }}</p>
                                <div class="ratings lh-1">
                                    <a href="https://wa.me/{{ $data_stores->wa_number }}" target="_blank">
                                        <span style="color: yellow;">{{ $data_stores->wa_number }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Vendor Basic Info-->
                        <div class="vendor-basic-info d-flex align-items-center justify-content-between mt-4">
                            <div class="single-basic-info">
                                <div class="icon"><i class="ti ti-heart"></i></div><span>@
                                    {{ $data_stores->user }}</span>
                            </div>
                            <div class="single-basic-info">
                                <div class="icon"><i class="ti ti-basket"></i></div>
                                <span>{{ $total_products }} Produk</span>
                            </div>

                            <div class="single-basic-info">
                                <div class="icon"><i class="ti ti-crown"></i></div><span>Terpercaya</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Vendor Tabs -->
                <div class="vendor-tabs">
                    <div class="container">
                        <ul class="nav nav-tabs mb-3" id="vendorTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">Tentang</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="products-tab" data-bs-toggle="tab"
                                    data-bs-target="#products" type="button" role="tab" aria-controls="products"
                                    aria-selected="false">Produk</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="links-tab" data-bs-toggle="tab" data-bs-target="#links"
                                    type="button" role="tab" aria-controls="links" aria-selected="false">Link</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content" id="vendorTabContent">
                    <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <div class="card">
                            <div class="card-body about-content-wrap dir-rtl">

                                <img src="/upload/users/{{ $data_stores->banner }}"
                                    alt="{{ $data_stores->user }}">


                            </div>
                        </div>

                        <div class="card mt-2">
                            <div class="card-body about-content-wrap dir-rtl">

                                @if (!empty($data_stores->embed_youtube))
                                    <div class="video-container">
                                        <iframe class="embed-responsive-item"
                                            src="https://www.youtube.com/embed/{{ $data_stores->embed_youtube }}?autoplay=1&rel=0&mute=1"
                                            allowfullscreen allow="autoplay; encrypted-media" frameborder="0"
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                @else
                                    <p class="text-center">Tidak ada video yang tersedia.</p>
                                @endif



                            </div>
                        </div>

                        <div class="card mt-2">
                            <div class="card-body about-content-wrap dir-rtl">
                                <h6>Selamat Datang di Toko : {{ $data_stores->name }}</h6>
                                <p>{!! $data_stores->description !!}</p>


                            </div>
                        </div>

                        <div class="card mt-2">
                            <div class="card-body about-content-wrap dir-rtl">
                                <p class="mb-2">Bagikan agar orang lain tahu banyak tentang toko ini.</p>
                                <!-- AddToAny BEGIN -->
                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                    <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                                    <a class="a2a_button_facebook"></a>
                                    <a class="a2a_button_whatsapp"></a>
                                    <a class="a2a_button_telegram"></a>
                                    <a class="a2a_button_x"></a>
                                    <a class="a2a_button_copy_link"></a>
                                </div>
                                <script defer src="https://static.addtoany.com/menu/page.js"></script>
                                <!-- AddToAny END -->



                            </div>
                        </div>

                        <div class="card mt-2">
                            <div class="card-body about-content-wrap dir-rtl">
                                <a class="btn btn-primary w-100" href="{{ $data_stores->maps }}">
                                    <i class="ti ti-map"></i> Buka Google Maps Toko
                                </a>



                            </div>
                        </div>



                    </div>
                    <div class="tab-pane fade show active" id="products" role="tabpanel"
                        aria-labelledby="products-tab">
                        <div class="row g-2 rtl-flex-d-row-r">
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
                                            <a class="d-block" href="{{ route('product.product_detail', $p->slug) }}">
                                                <img class="image-thumbnail lazy-img"
                                                    src="https://placehold.co/300x200?text=Loading..."
                                                    data-src="/upload/products/{{ $p->image }}"
                                                    data-original="/upload/products/{{ $p->image }}"
                                                    alt="{{ $p->name }}">
                                            </a>
                                            <!-- Offer Countdown Timer: Please use event time this format: YYYY/MM/DD hh:mm:ss -->
                                            <!-- <ul class="offer-countdown-timer d-flex align-items-center shadow-sm" data-countdown="2024/12/31 23:59:59">
                                            <li><span class="days">0</span>d</li>
                                            <li><span class="hours">0</span>h</li>
                                            <li><span class="minutes">0</span>m</li>
                                            <li><span class="seconds">0</span>s</li>
                                        </ul> -->
                                            </a>
                                            <a class="store-badge"
                                                href="{{ url('produk?category=' . $p->category->slug) }}">
                                                {{ $p->category->name ?? 'Tanpa Kategori' }}
                                            </a>

                                            <a class="product-title"
                                                href="{{ route('product.product_detail', $p->slug) }}"
                                                alt="{{ $p->name }}" title="{{ $p->name }}">
                                                {{ $p->name }}
                                            </a>





                                            <!-- <p class="sale-price">$13<span>$42</span></p> -->

                                            <p class="sale-price-new">
                                                Rp {{ number_format($p->cost_price, 0, ',', '.') }}
                                                @if ($p->price_before_discount && $p->price_before_discount > 0)
                                                    <br> <span class="old-price">Rp
                                                        {{ number_format($p->price_before_discount, 0, ',', '.') }}</span>
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
                                            <form class="add-to-cart-form" data-product-id="{{ $p->id }}">
                                                @csrf
                                                <button class="btn btn-primary btn-sm" type="button"><i
                                                        class="ti ti-shopping-cart"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="shop-pagination pt-2">
                                <div class="card">
                                    <div class="card-body py-2">
                                        {{ $data_products->links('vendor.pagination.bootstrap-4') }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="links" role="tabpanel" aria-labelledby="links-tab">
                        <!-- Rating & Review Wrapper -->
                        <div class="rating-and-review-wrapper bg-white py-3 mb-3 dir-rtl">
                            <div class="rating-review-content">
                                <ul class="ps-0">
                                    <!-- Single User Review -->
                                    <li class="single-user-review">
                                        <div class="contact-btn-wrap text-center">
                                            <p class="mb-2">Kunjungi juga link lain dari toko ini untuk melengkapi
                                                referensi belanja anda.</p>
                                            <div class="container">
                                                @foreach ($data_stores->links as $link)
                                                    <a class="btn btn-danger w-100 my-2" href="{{ $link->link }}"
                                                        target="_blank">
                                                        <i class="ti ti-link me-1 h6"></i>{{ $link->name }}
                                                    </a>
                                                @endforeach
                                            </div>


                                        </div>
                                    </li>


                                </ul>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>

    </div>


    </div>
@endsection
