@extends('front.layouts.app')


@section('content')

<div class="page-content-wrapper">


  <div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
      <!-- Back Button-->
      <div class="back-button me-2"><a href="/"><i class="ti ti-arrow-left"></i></a></div>
      <!-- Page Title-->
      <div class="page-heading">
        <h6 class="mb-0">{{$subtitle}}</h6>
      </div>
      <div class="suha-navbar-toggler ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas" aria-controls="suhaOffcanvas">
        <div><span></span><span></span><span></span></div>
      </div>
    </div>
  </div>

  <div class="pb-3 pt-3">
    <div class="container">
      <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
        <h6>Kategori</h6></a>
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
        <h6>Produk Pilihan</h6><a class="btn btn-sm btn-light" href="/l">Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
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
              <a class="store-badge" href="/">{{ $p->category->name ?? 'Tanpa Kategori' }}</a>
              <a class="product-title" href="/">{{ $p->name }}</a>





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



</div>

@endsection