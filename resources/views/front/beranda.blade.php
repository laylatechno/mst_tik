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
                        <img
                            class="category-thumbnail"
                            src="{{ $p->image ? '/upload/product_categories/' . $p->image : asset('template/front/img/kategori.png') }}"
                            alt="{{ $p->name }}"
                            loading="lazy"
                            data-original="{{ $p->image ? '/upload/product_categories/' . $p->image : asset('template/front/img/kategori.png') }}">
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


    @include('front.products-category-top')



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



  
    @include('front.blog-home')




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

  

    @include('front.products-category-discount')
    @include('front.products-category-one')
    @include('front.products-category-two')
    @include('front.products-category-three')

   

  

</div>

@endsection