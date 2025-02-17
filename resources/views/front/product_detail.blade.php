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
        <!-- Single Hero Slide-->
        <div class="single-product-slide" data-bs-toggle="modal" data-bs-target="#imageModal"
          data-image="/upload/products/{{ $product->image }}"
          style="background-image: url('/upload/products/{{ $product->image }}')">
        </div>

        @foreach($product->images as $image)
        <div class="single-product-slide" data-bs-toggle="modal" data-bs-target="#imageModal"
          data-image="/upload/products/details/{{ $image->image }}"
          style="background-image: url('/upload/products/details/{{ $image->image }}')">
        </div>
        @endforeach
      </div>

      <!-- Video Button -->
      <a class="video-btn shadow-sm" id="singleProductVideoBtn" href="{{$product->link}}">
        <i class="ti ti-player-play"></i>
      </a>
    </div>

    <!-- Modal untuk menampilkan gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
          <div class="modal-body p-0">
            <!-- Swiper untuk Slide Gambar -->
            <div class="swiper mySwiper">
              <div class="swiper-wrapper">
                <!-- Gambar utama dulu -->
                <div class="swiper-slide">
                  <img id="modalImage" src="/upload/products/{{ $product->image }}" class="img-fluid">
                </div>
                <!-- Looping gambar detail -->
                @foreach($product->images as $image)
                <div class="swiper-slide">
                  <img src="/upload/products/details/{{ $image->image }}" class="img-fluid">
                </div>
                @endforeach
              </div>
              <!-- Navigasi Swipe -->
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <script>
      // Inisialisasi Swiper
      var swiper = new Swiper(".mySwiper", {
        loop: true,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });

      // Update modalImage saat klik gambar utama atau detail
      document.querySelectorAll('.single-product-slide').forEach(item => {
        item.addEventListener('click', function() {
          let imageSrc = this.getAttribute('data-image');
          document.getElementById('modalImage').src = imageSrc;

          // Reset Swiper ke slide pertama
          swiper.slideTo(0);
        });
      });
    </script>



    <div class="product-description pb-3">
      <!-- Product Title & Meta Data-->
      <div class="product-title-meta-data bg-white mb-3 py-3">
        <div class="container d-flex justify-content-between rtl-flex-d-row-r">
          <div class="p-title-price">
            <h5 class="mb-1">{{$product->name}}</h5>
            <p class="sale-price mb-0 lh-1">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</p>
          </div>
        </div>


      </div>

      <!-- Add To Cart-->
      <div class="cart-form-wrapper bg-white mb-3 py-3">
        <div class="container">
          <form class="cart-form" action="#" method="">
            <div class="order-plus-minus d-flex align-items-center">
              <div class="quantity-button-handler">-</div>
              <input class="form-control cart-quantity-input" type="text" step="1" name="quantity" value="1">
              <div class="quantity-button-handler">+</div>
            </div>
            <button class="btn btn-primary ms-3" type="submit">Tambahkan Ke Keranjang</button>
          </form>
        </div>
      </div>
      <!-- Product Specification-->
      <div class="p-specification bg-white mb-3 py-3">
        <div class="container">
          <h6>Deskripsi</h6>
          <p>{!!$product->description!!}</p>
        </div>
      </div>
      <!-- Product Video -->
      <div class="bg-img" style="background-image: url('/upload/products/{{ $product->image }}')">
        <div class="container">
          <div class="video-cta-content d-flex align-items-center justify-content-center">
            <div class="video-text text-center">
              <h4 class="mb-4">{{$product->name}}</h4><a class="btn btn-primary rounded-circle" id="videoButton" href="{{$product->link}}"><i class="ti ti-player-play"></i></a>
            </div>
          </div>
        </div>
      </div>


      <!-- Related Products Slides-->
      <div class="top-products-area py-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
            <h6>Produk Terkait</h6>
          </div>
          <div class="row g-2">
            @foreach ($product_other as $p)
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
                  <a class="btn btn-primary btn-sm" href="/"><i class="ti ti-shopping-cart"></i></a>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="container py-2">
          <div class="card">
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
        </div>

       
    </div>
  </div>
</div>


</div>

@endsection