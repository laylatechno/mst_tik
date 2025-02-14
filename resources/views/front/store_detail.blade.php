@extends('front.layouts.app')

<style>
  .video-container {
  position: relative;
  width: 100%; /* Full width sesuai container */
  padding-top: 56.25%; /* Rasio 16:9 */
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
        <h6 class="mb-0">{{$subtitle}}</h6>
      </div>
      <!-- Navbar Toggler-->
      <div class="suha-navbar-toggler ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas" aria-controls="suhaOffcanvas">
        <div><span></span><span></span><span></span></div>
      </div>
    </div>
  </div>

  <div class="page-content-wrapper pb-3">
    <!-- Vendor Details Wrap -->
    <div class="vendor-details-wrap bg-img bg-overlay py-4" style="background-image: url('/upload/users/{{ $data_stores->banner }}')">
      <div class="container">
        <div class="d-flex align-items-start">
          <!-- Vendor Profile-->
          <div class="vendor-profile shadow me-3">
            <figure class="m-0"><img src="/upload/users/{{ $data_stores->image }}" alt=""></figure>
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
            <div class="icon"><i class="ti ti-heart"></i></div><span>@ {{ $data_stores->user }}</span>
          </div>
          <div class="single-basic-info">
            <div class="icon"><i class="ti ti-basket"></i></div><span>100 Produk</span>
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
            <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Tentang</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab" aria-controls="products" aria-selected="false">Produk</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="links-tab" data-bs-toggle="tab" data-bs-target="#links" type="button" role="tab" aria-controls="links" aria-selected="false">Link</button>
          </li>
        </ul>
      </div>
    </div>
    <div class="tab-content" id="vendorTabContent">
      <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="container pb-2">
          <div class="card">
            <div class="card-body about-content-wrap dir-rtl">

              @if (!empty($data_stores->embed_youtube))
              <div class="video-container">
                <iframe class="embed-responsive-item"
                  src="https://www.youtube.com/embed/{{ $data_stores->embed_youtube }}?autoplay=1&rel=0&mute=1"
                  allowfullscreen allow="autoplay; encrypted-media" frameborder="0" loading="lazy">
                </iframe>
              </div>
              @else
              <p class="text-center">Tidak ada video yang tersedia.</p>
              @endif



            </div>
          </div>
        </div>
        <div class="container">
          <div class="card">
            <div class="card-body about-content-wrap dir-rtl">
              <h6>Selamat Datang di Toko : {{$data_stores->name}}</h6>
              <p>{!!$data_stores->description!!}</p>

              <div class="contact-btn-wrap text-center">
                <br>
                <p class="mb-2">Bagikan agar orang lain tahu banyak tentang toko ini.</p>
                <a class="btn btn-success w-100 my-2" href="/"><i class="ti ti-share me-1 h6"></i>Bagikan ke WhatsApp</a>
                <a class="btn btn-primary w-100 my-2" href="/"><i class="ti ti-share me-1 h6"></i>Bagikan ke Facebook</a>
                <a class="btn btn-warning w-100 my-2" href="/"><i class="ti ti-share me-1 h6"></i>Bagikan ke Twitter</a>


              </div>
            </div>
          </div>
        </div>
        <div class="container py-2">
          <div class="card">
            <div class="card-body about-content-wrap dir-rtl">
            <a class="btn btn-secondary w-100" href="{{ $data_stores->maps }}">
                                        <i class="ti ti-map"></i> Buka Google Maps Toko
                                    </a>



            </div>
          </div>
        </div>

        
      </div>
      <div class="tab-pane fade show active" id="products" role="tabpanel" aria-labelledby="products-tab">
        <div class="container">
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
      <div class="tab-pane fade" id="links" role="tabpanel" aria-labelledby="links-tab">
        <!-- Rating & Review Wrapper -->
        <div class="rating-and-review-wrapper bg-white py-3 mb-3 dir-rtl">
          <div class="container">
            <div class="rating-review-content">
              <ul class="ps-0">
                <!-- Single User Review -->
                <li class="single-user-review d-flex">
                  <div class="contact-btn-wrap text-center">
                    <p class="mb-2">Kunjungi juga link lain untuk melengkapi referensi belanja anda.</p>

                    @foreach($data_stores->links as $link)
                    <a class="btn btn-danger w-100 my-2" href="{{ $link->link }}" target="_blank">
                      <i class="ti ti-link me-1 h6"></i>{{ $link->name }}
                    </a>
                    @endforeach

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