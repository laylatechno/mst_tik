@extends('front.layouts.app')

<style>
    .lazy-slide {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        filter: blur(10px);
        /* Blur sebelum gambar muncul */
        transition: filter 0.5s ease-in-out;
    }

    .lazy-slide.loaded {
        filter: blur(0);
    }
</style>

@section('content')

<div class="page-content-wrapper">


    <!-- Hero Wrapper -->
    <div class="hero-wrapper">
        <div class="container">
            <div class="pt-3">
                <!-- Hero Slides -->
                <div class="hero-slides owl-carousel">
                    @foreach ($data_sliders as $p)
                    <!-- Single Hero Slide -->
                    <div class="single-hero-slide lazy-slide" data-bg="/upload/sliders/{{ $p->image }}">
                        <div class="slide-content h-100 d-flex align-items-center">
                            <div class="slide-text">
                                <!-- <h4 class="text-white mb-0">{{ $p->name }}</h4>
                            <p class="text-white">{{ $p->description }}</p> -->
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

                    <a class="image-thumbnail d-block" href="{{ url('produk?category=' . $p->slug) }}">
                        <img class="lazy-img"
                            src="https://placehold.co/300x200?text=Loading..."
                            data-src="{{ $p->image ? '/upload/product_categories/' . $p->image : asset('template/front/img/kategori.png') }}"
                            data-original="{{ $p->image ? '/upload/product_categories/' . $p->image : asset('template/front/img/kategori.png') }}"
                            alt="{{ $p->name }}">
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

                        <a class="d-block" href="{{ route('product.product_detail', $p->slug) }}">
                            <img class="image-thumbnail lazy-img"
                                src="https://placehold.co/300x200?text=Loading..."
                                data-src="/upload/products/{{ $p->image }}"
                                data-original="/upload/products/{{ $p->image }}"
                                alt="{{ $p->name }}">
                        </a>


                        </a>
                        <a class="store-badge" href="{{ url('produk?category=' . $p->category->slug) }}">
                            {{ $p->category->name ?? 'Tanpa Kategori' }}
                        </a>

                        <a class="product-title" href="{{ route('product.product_detail', $p->slug) }}">
                            {{ $p->name }}
                        </a>



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
                        <form class="add-to-cart-form" data-product-id="{{ $p->id }}">
                            @csrf
                            <button class="btn btn-primary btn-sm" type="button"><i class="ti ti-shopping-cart"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</div>



    <div class="container py-2">
        <div class="row gy-3">
            @if ($data_stores)
            <div class="col-12">
                <!-- Single Vendor -->
                <div class="single-vendor-wrap bg-img p-4 bg-overlay" style="background-image: url('/upload/users/{{ $data_stores->banner }}')">
                    <h6 class="vendor-title text-white">
                        <a href="{{ route('store.store_detail', $data_stores->user) }}" class="text-white">
                            {{ $data_stores->name }}
                        </a>
                    </h6>
                    <div class="vendor-info">
                        <p class="mb-1 text-white"><i class="ti ti-briefcase me-1"></i>{{ $data_stores->about }}</p>
                        <p class="mb-1 text-white"><i class="ti ti-map-pin me-1"></i>{{ $data_stores->address }}</p>
                        <div class="ratings lh-1">
                            <a href="https://wa.me/{{ $data_stores->wa_number }}" target="_blank">
                                <span style="color: yellow;">{{ $data_stores->wa_number }}</span>
                            </a>
                        </div>
                    </div>
                    <a class="btn btn-primary btn-sm mt-3" href="{{ route('store.store_detail', $data_stores->user) }}">
                        Kunjungi Toko <i class="ti ti-arrow-right ms-1"></i>
                    </a>
                    <!-- Vendor Profile-->
                    <div class="vendor-profile shadow">
                        <figure class="m-0"><img src="/upload/users/{{ $data_stores->image }}" alt=""></figure>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>




   
  <!-- Weekly Best Sellers-->
  <div class="weekly-best-seller-area pt-2">
      <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
              <h6>Informasi Terbaru</h6><a class="btn btn-sm btn-light" href="{{ asset('template/front') }}/shop-list.html">
                  Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
          </div>
          <div class="row g-2">
              @foreach ($data_blogs as $p)
              <div class="col-12">
                  <div class="card horizontal-product-card">
                      <div class="d-flex align-items-center">
                          <div class="product-thumbnail-side">
                              <a class="product-thumbnail d-block" href="{{ route('product.product_detail', $p->slug) }}">
                                  <img
                                      class="mb-2 lazy-img"
                                      src="https://placehold.co/300x200?text=Loading..."
                                      data-src="/upload/blogs/{{ $p->image }}"
                                      alt="{{ $p->titile }}">
                              </a>
                          </div>
                          <div class="product-description py-2">
                              <!-- Product Title --><a class="product-title d-block" href="/">{{ $p->title }}</a>


                              <p>
                              {{ $p->writer }}<span class="ms-1"> | {{ $p->posting_date }} </span>
                              </p>
                              <p class="sale-price"><i class="ti ti-tag"></i>Olahraga</p>
                          </div>
                      </div>
                  </div>
              </div>
              @endforeach

          </div>
      </div>
  </div>



    <!-- CTA Area -->
    <div class="container py-3">
        <div class="cta-text dir-rtl p-4 p-lg-5">
            <div class="row">
                <div class="col-9">
                    <h5 class="text-white">Bisnis Anda Butuh Aplikasi/Website?</h5><a class="btn btn-primary" href=""><i class="ti ti-bell"></i> Hubungi Kami</a>
                </div>
            </div>
            <img
                class="website-thumbnail"
                src="{{ asset('template/front') }}/img/website.png"
                alt=""
                loading="lazy"
                data-original="{{ asset('template/front') }}/img/website.png">
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

                        <a class="d-block" href="{{ route('product.product_detail', $p->slug) }}">
                            <img class="image-thumbnail lazy-img"
                                src="https://placehold.co/300x200?text=Loading..."
                                data-src="/upload/products/{{ $p->image }}"
                                data-original="/upload/products/{{ $p->image }}"
                                alt="{{ $p->name }}">
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
                            <form class="add-to-cart-form" data-product-id="{{ $p->id }}">
                                @csrf
                                <button class="btn btn-primary btn-sm" type="button"><i class="ti ti-shopping-cart"></i></button>
                            </form>
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

                        <a class="d-block" href="{{ route('product.product_detail', $p->slug) }}">
                            <img class="image-thumbnail lazy-img"
                                src="https://placehold.co/300x200?text=Loading..."
                                data-src="/upload/products/{{ $p->image }}"
                                data-original="/upload/products/{{ $p->image }}"
                                alt="{{ $p->name }}">
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
                            <form class="add-to-cart-form" data-product-id="{{ $p->id }}">
                                @csrf
                                <button class="btn btn-primary btn-sm" type="button"><i class="ti ti-shopping-cart"></i></button>
                            </form>
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

                        <a class="d-block" href="{{ route('product.product_detail', $p->slug) }}">
                            <img class="image-thumbnail lazy-img"
                                src="https://placehold.co/300x200?text=Loading..."
                                data-src="/upload/products/{{ $p->image }}"
                                data-original="/upload/products/{{ $p->image }}"
                                alt="{{ $p->name }}">
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
                            <form class="add-to-cart-form" data-product-id="{{ $p->id }}">
                                @csrf
                                <button class="btn btn-primary btn-sm" type="button"><i class="ti ti-shopping-cart"></i></button>
                            </form>
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

                        <a class="d-block" href="{{ route('product.product_detail', $p->slug) }}">
                            <img class="image-thumbnail lazy-img"
                                src="https://placehold.co/300x200?text=Loading..."
                                data-src="/upload/products/{{ $p->image }}"
                                data-original="/upload/products/{{ $p->image }}"
                                alt="{{ $p->name }}">
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
                            <form class="add-to-cart-form" data-product-id="{{ $p->id }}">
                                @csrf
                                <button class="btn btn-primary btn-sm" type="button"><i class="ti ti-shopping-cart"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lazySlides = document.querySelectorAll(".lazy-slide");

            const lazyLoadSlide = (slide) => {
                const bg = slide.getAttribute("data-bg");
                if (bg) {
                    slide.style.backgroundImage = `url('${bg}')`;
                    slide.classList.add("loaded"); // Tambahkan efek transisi
                }
            };

            if ("IntersectionObserver" in window) {
                let observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            lazyLoadSlide(entry.target);
                            observer.unobserve(entry.target);
                        }
                    });
                });

                lazySlides.forEach((slide) => observer.observe(slide));
            } else {
                // Fallback untuk browser lama
                lazySlides.forEach((slide) => lazyLoadSlide(slide));
            }
        });
    </script>



</div>

@endsection