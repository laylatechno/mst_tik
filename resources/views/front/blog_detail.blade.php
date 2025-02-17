@extends('front.layouts.app')
<style>
  .bg-img {
    position: relative;
    background-size: cover;
    background-position: center;
  }

  .bg-img::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    /* Overlay hitam dengan opacity 40% */
  }
</style>

<!-- Tambahkan Swiper.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>




@section('content')

<div class="page-content-wrapper">


  <!-- Header Area-->
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

  <div class="page-content-wrapper">
    <div class="product-slide-wrapper">
      <!-- Product Slides-->
      <div class="product-slides owl-carousel">
        <div class="single-product-slide" data-bs-toggle="modal" data-bs-target="#imageModal"
          data-image="/upload/blogs/{{ $blog->image }}"
          style="background-image: url('/upload/blogs/{{ $blog->image }}')">
        </div>
      </div>

      <!-- Video Button -->
      @if($blog->link)
      <a class="video-btn shadow-sm" id="singleProductVideoBtn" href="{{ $blog->link }}">
        <i class="ti ti-player-play"></i>
      </a>
      @endif
    </div>

    <!-- Modal untuk Gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
          <div class="modal-body p-0">
            <img id="modalImage" src="/upload/blogs/{{ $blog->image }}" class="img-fluid">
          </div>
        </div>
      </div>
    </div>

    <div class="product-description pb-3">
      <!-- Judul & Meta Data -->
      <div class="product-title-meta-data bg-white mb-3 py-3">
        <div class="container d-flex justify-content-between rtl-flex-d-row-r">
          <div class="p-title-price">
            <h5 class="mb-1">{{ $blog->title }}</h5>
            <p class="sale-price mb-0 lh-1">{{ $blog->writer }} | {{ $blog->posting_date }}</p>
          </div>
        </div>
      </div>

      <!-- Deskripsi -->
      <div class="p-specification bg-white mb-3 py-3">
        <div class="container">
          <h6>Deskripsi</h6>
          <p>{!! $blog->description !!}</p>
        </div>
      </div>

      <!-- Video Section -->
      @if($blog->link)
      <div class="bg-img" style="background-image: url('/upload/blogs/{{ $blog->image }}')">
        <div class="container">
          <div class="video-cta-content d-flex align-items-center justify-content-center">
            <div class="video-text text-center">
              <h4 class="mb-4">{{ $blog->title }}</h4>
              <a class="btn btn-primary rounded-circle" id="videoButton" href="{{ $blog->link }}">
                <i class="ti ti-player-play"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      @endif

      <!-- Bagikan -->
      <div class="container py-2">
        <div class="card">
          <div class="card-body about-content-wrap dir-rtl">
            <p class="mb-2">Bagikan agar orang lain tahu banyak tentang artikel ini.</p>
            <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
              <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
              <a class="a2a_button_facebook"></a>
              <a class="a2a_button_whatsapp"></a>
              <a class="a2a_button_telegram"></a>
              <a class="a2a_button_x"></a>
              <a class="a2a_button_copy_link"></a>
            </div>
            <script defer src="https://static.addtoany.com/menu/page.js"></script>
          </div>
        </div>
      </div>
    </div>
  </div>



</div>


</div>

@endsection