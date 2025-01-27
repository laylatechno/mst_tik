@extends('front.layouts.app')


@section('content')
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<style>
  .category-item {
    border: 1px solid #ddd;
    border-radius: 25px;
    padding: 10px 20px;
    margin: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    background: white;
    cursor: pointer;
    transition: all 0.3s;
  }

  .category-item:hover {
    background: #f8f9fa;
  }

  .category-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .slider-container {
    position: relative;
    padding: 0 40px;
  }

  .scroll-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: white;
    border: 1px solid #ddd;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 1;
  }

  .scroll-btn.prev {
    left: 0;
  }

  .scroll-btn.next {
    right: 0;
  }

  .categories-wrapper {
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
  }

  .categories-wrapper::-webkit-scrollbar {
    display: none;
  }
</style>

<style>
  .occasions-container {
    padding: 20px;
  }

  .occasion-item {
    display: flex;
    align-items: center;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #eee;
    margin-bottom: 15px;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .occasion-item:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .occasion-image {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 15px;
  }

  .occasion-info {
    flex-grow: 1;
  }

  .occasion-title {
    font-weight: 500;
    margin-bottom: 4px;
    color: #333;
  }

  .occasion-count {
    font-size: 0.9em;
    color: #666;
  }
</style>

<style>
  .custom-product-slider {
    position: relative;
    padding: 20px 40px;
  }

  .custom-slider-wrapper {
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
    scroll-behavior: smooth;
  }

  .custom-slider-wrapper::-webkit-scrollbar {
    display: none;
  }

  .custom-product-list {
    display: flex;
    gap: 20px;
    padding: 10px 0;
  }

  .custom-product-card {
    flex: 0 0 auto;
    width: 120px;
    text-align: center;
    cursor: pointer;
    transition: transform 0.3s ease;
  }

  .custom-product-card:hover {
    transform: translateY(-5px);
  }

  .custom-product-image {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .custom-product-name {
    font-size: 14px;
    color: #333;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .custom-scroll-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid #ddd;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 1;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }

  .custom-scroll-btn:hover {
    background: #f8f9fa;
    transform: translateY(-50%) scale(1.1);
  }

  .custom-scroll-btn.custom-prev {
    left: 0;
  }

  .custom-scroll-btn.custom-next {
    right: 0;
  }
</style>

<style>
  .custom-client-slider {
    position: relative;
    padding: 20px 40px;
  }

  .custom-slider-client-wrapper {
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
    scroll-behavior: smooth;
  }

  .custom-slider-wrapper::-webkit-scrollbar {
    display: none;
  }

  .custom-client-list {
    display: flex;
    gap: 20px;
    padding: 10px 0;
  }

  .custom-client-card {
    flex: 0 0 auto;
    width: 120px;
    text-align: center;
    cursor: pointer;
    transition: transform 0.3s ease;
  }

  .custom-client-card:hover {
    transform: translateY(-5px);
  }

  .custom-client-image {
    width: 620px;
    height: 120px;
    /* border-radius: 50%; */
    object-fit: cover;
    margin-bottom: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .custom-client-name {
    font-size: 14px;
    color: #333;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .custom-scroll-btn-client {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid #ddd;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 1;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }

  .custom-scroll-btn-client:hover {
    background: #f8f9fa;
    transform: translateY(-50%) scale(1.1);
  }

  .custom-scroll-btn-client.custom-prev-client {
    left: 0;
  }

  .custom-scroll-btn-client.custom-next-client {
    right: 0;
  }
</style>


<style>
  .info-area {
    padding: 50px 0;
    background-color: #f8f9fa;
  }

  .single-info {
    background: white;
    border-radius: 25px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: column;
  }

  .single-info:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  }

  .info-image {
    position: relative;
    overflow: hidden;
  }

  .info-image img {
    width: 100%;
    display: block;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .info-content {
    padding: 25px 30px;
    text-align: center;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .info-content h4 {
    margin-bottom: 15px;
    font-size: 24px;
    font-weight: 600;
  }

  .info-content h4 a {
    color: #333;
    text-decoration: none;
  }

  .info-content p {
    color: #666;
    margin-bottom: 20px;
    line-height: 1.6;
    flex-grow: 1;
  }

  .read-more-info {
    margin-top: auto;
  }

  .read-more-info a {
    display: inline-block;
    padding: 12px 30px;
    background-color: #1a1a1a;
    color: #ffd700;
    text-decoration: none;
    border-radius: 25px;
    transition: all 0.3s ease;
    font-weight: 500;
  }

  .read-more-info a:hover {
    background-color: #333;
    transform: translateY(-2px);
  }

  .read-more-info a i {
    margin-right: 5px;
  }


  @media (max-width: 768px) {
    .info-area {
      padding: 30px 0;
      /* Mengurangi padding area di mobile */
    }

    .row.g-4 {
      --bs-gutter-y: 2rem;
      /* Menambah jarak vertikal antar card di mobile */
    }

    .single-info {
      margin-bottom: 20px;
      /* Tambahan margin bottom untuk spacing */
    }

    .info-content {
      padding: 20px;
    }

    /* Menghapus margin bottom dari card terakhir */
    .col-md-6:last-child .single-info {
      margin-bottom: 0;
    }
  }
</style>


<style>
  .banner-area {
    overflow: hidden;
    position: relative;
  }

  .slider-container {
    width: 100%;
    position: relative;
  }

  .slides {
    display: flex;
    transition: transform 0.5s ease;
  }

  .slide {
    min-width: 100%;
    padding: 30px 0;
  }

  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
  }

  .row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px;
  }

  .col-lg-6 {
    flex: 0 0 50%;
    max-width: 50%;
    padding: 0 15px;
  }

  .single-banner-two {

    padding: 30px;
    border-radius: 8px;
    height: 100%;
  }


  .banner-content-two {
    text-align: left;
  }

  .banner-content-box h3 {
    margin: 10px 0;
    font-size: 24px;
  }

  .banner-content-box span {
    color: #ff4444;
    font-weight: bold;
  }

  .banner-content-box a {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background: #333;
    color: white;
    text-decoration: none;
    border-radius: 4px;
  }

  /* Navigation Arrows */
  .slider-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border-radius: 50%;
    font-size: 20px;
    z-index: 10;
    transition: background 0.3s;
  }

  .slider-nav:hover {
    background: rgba(0, 0, 0, 0.8);
  }

  .prev {
    left: 20px;
  }

  .next {
    right: 20px;
  }

  /* Bullet Indicators */
  .slider-dots {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
  }

  .dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    border: 2px solid #333;
  }

  .dot.active {
    background: #333;
  }

  @media (max-width: 992px) {
    .col-lg-6 {
      flex: 0 0 100%;
      max-width: 100%;
    }
  }
</style>


<!-- Hero Section Start -->
<div class="hero-slider hero-slider-one">

  <!-- Single Slide Start -->
  <div class="single-slide" style="background-image: url({{ asset('template/front') }}/assets/images/slider/1.png)">
    <!-- Hero Content One Start -->
    <div class="hero-content-one container">
      <div class="row">
        <div class="col-lg-10 col-md-10">
          <div class="slider-text-info">
            <h2>Idul <span>Fitri</span> </h2>
            <h1>Kini <span>Lebih</span> Bermakna </h1>
            <p>Dengan Ungkapan Kasih Sayang Lewat Sajian Yang Indah dan Elegan Bersama Monera</p>
            <div class="hero-btn">
              <a href="https://wa.me/{{ $profil->no_wa }}?text=Hallo%20Admin%20{{ $profil->nama_profil }},%20saya%20ingin%20menanyakan%20beberapa%20hal%20umum.%20Mohon%20informasikan%20lebih%20lanjut." class="slider-btn uppercase"><span>PESAN SEKARANG</span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Hero Content One End -->
  </div>
  <!-- Single Slide End -->


  <!-- Single Slide Start -->
  <div class="single-slide" style="background-image: url({{ asset('template/front') }}/assets/images/slider/2.png)">
    <!-- Hero Content One Start -->
    <div class="hero-content-one container">
      <div class="row">
        <div class="col-lg-10 col-md-10">
          <div class="slider-text-info">
            <h2>Perayaan <span>Natal</span> </h2>
            <h1>Dan <span>Tahun</span> Baru </h1>
            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words...</p>
            <div class="hero-btn">
              <a href="https://wa.me/{{ $profil->no_wa }}?text=Hallo%20Admin%20{{ $profil->nama_profil }},%20saya%20ingin%20menanyakan%20beberapa%20hal%20umum.%20Mohon%20informasikan%20lebih%20lanjut." class="slider-btn uppercase"><span>PESAN SEKARANG</span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Hero Content One End -->
  </div>
  <!-- Single Slide End -->


  <!-- Single Slide Start -->
  <div class="single-slide" style="background-image: url({{ asset('template/front') }}/assets/images/slider/3.png)">
    <!-- Hero Content One Start -->
    <div class="hero-content-one container">
      <div class="row">
        <div class="col-lg-10 col-md-10">
          <div class="slider-text-info">
            <h2>Imlek <span>Berbeda</span> </h2>
            <h1>Dengan <span>Ucapan</span> Elegan </h1>
            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words...</p>
            <div class="hero-btn">
              <a href="https://wa.me/{{ $profil->no_wa }}?text=Hallo%20Admin%20{{ $profil->nama_profil }},%20saya%20ingin%20menanyakan%20beberapa%20hal%20umum.%20Mohon%20informasikan%20lebih%20lanjut." class="slider-btn uppercase"><span>PESAN SEKARANG</span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Hero Content One End -->
  </div>
  <!-- Single Slide End -->


</div>
<!-- Hero Section End -->

 
  <div class="custom-product-slider">
    <button class="custom-scroll-btn custom-prev">
      <i class="fas fa-chevron-left"></i>
    </button>

    <div class="custom-slider-wrapper">
      <div class="custom-product-list">
        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Bunga Papan">
            <img src="https://www.delovery.com/images/icons/bunga-papan-M2U3ZTUxZ.webp" class="custom-product-image" alt="Bunga Papan">
            <p class="custom-product-name">Bunga Papan</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Parcel">
            <img src="https://www.delovery.com/images/icons/parcel-MDBkNDMy.webp" class="custom-product-image" alt="Parcel">
            <p class="custom-product-name">Parcel</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Hand Bouquet">
            <img src="https://www.delovery.com/images/icons/buket-bunga-MzY2OGZ.webp" class="custom-product-image" alt="Hand Bouquet">
            <p class="custom-product-name">Hand Bouquet</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Standing Flower">
            <img src="https://www.delovery.com/images/icons/standing-flower-Mzc3YTNhY.webp" class="custom-product-image" alt="Standing Flower">
            <p class="custom-product-name">Standing Flower</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Cake & Pudding">
            <img src="https://www.delovery.com/images/icons/kue-ulang-tahun-OTYyMTM3.webp" class="custom-product-image" alt="Cake & Pudding">
            <p class="custom-product-name">Cake & Pudding</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Standing Paper Flower">
            <img src="https://www.delovery.com/images/icons/bunga-papan-M2U3ZTUxZ.webp" class="custom-product-image" alt="Standing Paper Flower">
            <p class="custom-product-name">Standing Paper Flower</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Table Bouquet">
            <img src="https://www.delovery.com/images/icons/rangkaian-bunga-meja-YjZkMTU0OT.webp" class="custom-product-image" alt="Table Bouquet">
            <p class="custom-product-name">Table Bouquet</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Money Gift">
            <img src="https://www.delovery.com/images/icons/bunga-papan-M2U3ZTUxZ.webp" class="custom-product-image" alt="Money Gift">
            <p class="custom-product-name">Money Gift</p>
          </a>
        </div>
        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Bunga Papan">
            <img src="https://www.delovery.com/images/icons/bunga-papan-M2U3ZTUxZ.webp" class="custom-product-image" alt="Bunga Papan">
            <p class="custom-product-name">Bunga Papan</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Parcel">
            <img src="https://www.delovery.com/images/icons/parcel-MDBkNDMy.webp" class="custom-product-image" alt="Parcel">
            <p class="custom-product-name">Parcel</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Hand Bouquet">
            <img src="https://www.delovery.com/images/icons/buket-bunga-MzY2OGZ.webp" class="custom-product-image" alt="Hand Bouquet">
            <p class="custom-product-name">Hand Bouquet</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Standing Flower">
            <img src="https://www.delovery.com/images/icons/standing-flower-Mzc3YTNhY.webp" class="custom-product-image" alt="Standing Flower">
            <p class="custom-product-name">Standing Flower</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Cake & Pudding">
            <img src="https://www.delovery.com/images/icons/kue-ulang-tahun-OTYyMTM3.webp" class="custom-product-image" alt="Cake & Pudding">
            <p class="custom-product-name">Cake & Pudding</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Standing Paper Flower">
            <img src="https://www.delovery.com/images/icons/bunga-papan-M2U3ZTUxZ.webp" class="custom-product-image" alt="Standing Paper Flower">
            <p class="custom-product-name">Standing Paper Flower</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Table Bouquet">
            <img src="https://www.delovery.com/images/icons/rangkaian-bunga-meja-YjZkMTU0OT.webp" class="custom-product-image" alt="Table Bouquet">
            <p class="custom-product-name">Table Bouquet</p>
          </a>
        </div>

        <div class="custom-product-card">
          <a href="#" class="wa-link" data-item="Money Gift">
            <img src="https://www.delovery.com/images/icons/bunga-papan-M2U3ZTUxZ.webp" class="custom-product-image" alt="Money Gift">
            <p class="custom-product-name">Money Gift</p>
          </a>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const profilNama = "{{ $profil->nama_profil }}"; // Nama profil dari backend Laravel
        const profilWa = "{{ $profil->no_wa }}"; // Nomor WhatsApp dari backend Laravel

        const waLinks = document.querySelectorAll('.wa-link');

        waLinks.forEach(link => {
          link.addEventListener('click', function(event) {
            event.preventDefault();
            const item = this.getAttribute('data-item');
            const message = `Hallo Admin ${profilNama}, saya ingin bertanya terkait kategori: ${item}.`;
            const whatsappUrl = `https://wa.me/${profilWa}?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
          });
        });
      });
    </script>


    <button class="custom-scroll-btn custom-next">
      <i class="fas fa-chevron-right"></i>
    </button>
  </div>
 

<div class="banner-area">
  <div class="slider-container">
    <div class="slides">
      <!-- Slide 1 -->
      <div class="slide">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-sm-12">
              <div class="single-banner-two" style="background-image: url({{ asset('template/front') }}/assets/images/slider/4.png); background-size: cover; background-position: center;">
                <div class="banner-content-two">
                  <div class="banner-content-box">
                    <a href="#" class="wa-button" data-item="Slide 1">PESAN SEKARANG</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="slide">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-sm-12">
              <div class="single-banner-two" style="background-image: url({{ asset('template/front') }}/assets/images/slider/5.png); background-size: cover; background-position: center;">
                <div class="banner-content-two">
                  <div class="banner-content-box">
                    <a href="#" class="wa-button" data-item="Slide 2">PESAN SEKARANG</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="slide">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-sm-12">
              <div class="single-banner-two" style="background-image: url({{ asset('template/front') }}/assets/images/slider/6.png); background-size: cover; background-position: center;">
                <div class="banner-content-two">
                  <div class="banner-content-box">
                    <a href="#" class="wa-button" data-item="Slide 3">PESAN SEKARANG</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const profilNama = "{{ $profil->nama_profil }}"; // Nama profil dari backend Laravel
        const profilWa = "{{ $profil->no_wa }}"; // Nomor WhatsApp dari backend Laravel

        const waButtons = document.querySelectorAll('.wa-button');

        waButtons.forEach(button => {
          button.addEventListener('click', function(event) {
            event.preventDefault();
            const item = this.getAttribute('data-item'); // Nama slide
            const message = `Hallo Admin ${profilNama}, saya ingin memesan produk yang ada di ${item}.`;
            const whatsappUrl = `https://wa.me/${profilWa}?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
          });
        });
      });
    </script>


    <!-- Navigation Arrows -->
    <div class="slider-nav prev">❮</div>
    <div class="slider-nav next">❯</div>
    <br>
    <!-- Bullet Indicators -->
    <div class="slider-dots"></div>
  </div>
</div>


<script>
  const slides = document.querySelector('.slides');
  const prevBtn = document.querySelector('.prev');
  const nextBtn = document.querySelector('.next');
  const dotsContainer = document.querySelector('.slider-dots');
  let currentSlide = 0;
  const totalSlides = document.querySelectorAll('.slide').length;

  // Create dots
  for (let i = 0; i < totalSlides; i++) {
    const dot = document.createElement('div');
    dot.classList.add('dot');
    if (i === 0) dot.classList.add('active');
    dot.addEventListener('click', () => goToSlide(i));
    dotsContainer.appendChild(dot);
  }

  function updateDots() {
    document.querySelectorAll('.dot').forEach((dot, index) => {
      dot.classList.toggle('active', index === currentSlide);
    });
  }

  function goToSlide(index) {
    currentSlide = index;
    slides.style.transform = `translateX(-${currentSlide * 100}%)`;
    updateDots();
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    goToSlide(currentSlide);
  }

  function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    goToSlide(currentSlide);
  }

  // Event listeners
  prevBtn.addEventListener('click', prevSlide);
  nextBtn.addEventListener('click', nextSlide);

  // Auto advance every 3 seconds
  let slideInterval = setInterval(nextSlide, 3000);

  // Pause auto-advance on hover
  slides.addEventListener('mouseenter', () => clearInterval(slideInterval));
  slides.addEventListener('mouseleave', () => slideInterval = setInterval(nextSlide, 3000));
</script>

<div class="container py-5">
  <div class="row g-4">
    <!-- Personalized Services -->
    <div class="col-lg-3 col-md-6">
      <div class="text-center">
        <div class="mb-3">
          <img src="https://www.delovery.com/images/pilihbunga-min.webp" alt="Personal Service" class="img-fluid" style="width: 64px;">
        </div>
        <h5 class="fw-bold mb-2">Personalized Services</h5>
        <p class="text-muted">Rekomendasi secara personal untuk occasion Anda. Gratis!</p>
      </div>
    </div>

    <!-- On-Time Guarantee -->
    <div class="col-lg-3 col-md-6">
      <div class="text-center">
        <div class="mb-3">
          <img src="https://www.delovery.com/images/Sameday-min.webp" alt="On-time Delivery" class="img-fluid" style="width: 64px;">
        </div>
        <h5 class="fw-bold mb-2">Garansi Tepat Waktu</h5>
        <p class="text-muted">Pesanan Anda dijamin tiba sesuai jadwal</p>
      </div>
    </div>

    <!-- Wide Coverage -->
    <div class="col-lg-3 col-md-6">
      <div class="text-center">
        <div class="mb-3">
          <img src="https://www.delovery.com/images/cities-min.webp" alt="Wide Coverage" class="img-fluid" style="width: 64px;">
        </div>
        <h5 class="fw-bold mb-2">Jangkauan Luas</h5>
        <p class="text-muted">Kirim ke LEBIH DARI 200++ Kota Di Indonesia</p>
      </div>
    </div>

    <!-- Free Shipping -->
    <div class="col-lg-3 col-md-6">
      <div class="text-center">
        <div class="mb-3">
          <img src="https://www.delovery.com/images/order-delivery-min.webp" alt="Free Shipping" class="img-fluid" style="width: 64px;">
        </div>
        <h5 class="fw-bold mb-2">Gratis Ongkir</h5>
        <p class="text-muted">FREE ONGKIR* Pengiriman Dalam Kota.</p>
      </div>
    </div>
  </div>
</div>


<div class="info-area section-ptb">
  <div class="container">
    <div class="row g-4"> <!-- Using g-4 for consistent gap -->
      <div class="col-lg-6 col-md-6">
        <div class="single-info">
          <div class="info-image">
            <a href="#">
              <img src="https://www.delovery.com/images/Template-Rangkaian-Bunga.webp" alt="Rangkaian Bunga">
            </a>
          </div>
          <div class="info-content">
            <h4><a href="#">Rangkaian Bunga</a></h4>
            <p>Sampaikan pesan dengan sempurna dengan karangan bunga untuk momen spesialmu, dari bunga papan, buket hingga standing flower</p>
            <div class="read-more-info">
              <a href="#" class="wa-direct" data-item="Rangkaian Bunga"><i class="ion-arrow-right-c"></i> Kirim Rangkaian Bunga</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6">
        <div class="single-info">
          <div class="info-image">
            <a href="#">
              <img src="https://www.delovery.com/images/gift-dan-parcel.webp" alt="Kado, Parcel & Hampers">
            </a>
          </div>
          <div class="info-content">
            <h4><a href="#">Kado, Parcel & Hampers</a></h4>
            <p>Temukan parcel eksklusif, hampers elegan, dan kado istimewa yang dirancang untuk segala acara.</p>
            <div class="read-more-info">
              <a href="#" class="wa-direct" data-item="Kado, Parcel & Hampers"><i class="ion-arrow-right-c"></i> Kirim Kado, Parcel & Hampers</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const profilNama = "{{ $profil->nama_profil }}"; // Nama profil dari backend Laravel
    const profilWa = "{{ $profil->no_wa }}"; // Nomor WhatsApp dari backend Laravel

    const waLinks = document.querySelectorAll('.wa-direct');

    waLinks.forEach(link => {
      link.addEventListener('click', function(event) {
        event.preventDefault();
        const item = this.getAttribute('data-item'); // Mendapatkan nama item dari data-item
        const message = `Hallo Admin ${profilNama}, saya tertarik dengan ${item}. Mohon informasinya lebih lanjut.`;
        const whatsappUrl = `https://wa.me/${profilWa}?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
      });
    });
  });
</script>


<!-- main-content-wrap start -->
<div class="main-content-wrap lagin-and-register-page" style="padding-top: 20px;">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 ml-auto mr-auto">
        <div class="login-register-wrapper">
          <!-- login-register-tab-list start -->

          <!-- login-register-tab-list end -->
          <div class="tab-content">
            <div id="lg1" class="tab-pane active">

              <div class="login-form-container">
                <h6 style="text-align: center;">
                  Alamat :
                </h6>
                <p style="text-align: center;">{{ $profil->alamat }}</p>

                <div class="row justify-content-center" style="width: 100%; margin: 20px 0;">
                  <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.3809286647124!2d108.18362739999999!3d-7.197304899999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f4f86b4dd88bd%3A0x83e221ebdaa97b94!2sMonerahandmade!5e0!3m2!1sen!2sid!4v1736127819115!5m2!1sen!2sid"
                    width="100%"
                    height="450"
                    style="border: 0; max-width: 100%;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                  </iframe>
                </div>
                <div class="button-box d-flex justify-content-center mt-3">
                  <a href="https://wa.me/{{ $profil->no_wa }}?text=Hallo%20Admin%20{{ $profil->nama_profil }},%20saya%20ingin%20menanyakan%20beberapa%20hal%20umum.%20Mohon%20informasikan%20lebih%20lanjut." target="_blank">
                    <button class="register-btn btn" type="button" style="padding: 10px 20px; background-color:rgb(27, 221, 75); color: white; border: none; border-radius: 5px; cursor: pointer;">
                      <span><i class="ion-social-whatsapp"></i> Hubungi Via WhatsApp</span>
                    </button>
                  </a>

                </div>
              </div>




            </div>

          </div>

        </div>
      </div>
    </div>
  </div>

</div>
</div>
<!-- main-content-wrap end -->

<!-- <div class="container occasions-container" style="margin-top:30px;">
  <h4 class="mb-4">Cari Berdasarkan Occasions</h4>

  <div class="row">
    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/duka-cita-ZTg4NjllYz.webp" class="occasion-image" alt="Duka Cita">
        <div class="occasion-info">
          <div class="occasion-title">Duka Cita</div>
          <div class="occasion-count">(921 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/ucapan-selamat-YzlhY2.webp" class="occasion-image" alt="Imlek">
        <div class="occasion-info">
          <div class="occasion-title">Terima Kasih</div>
          <div class="occasion-count">(121 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/pernikahan-NWI3MDYy.webp" class="occasion-image" alt="Pernikahan">
        <div class="occasion-info">
          <div class="occasion-title">Pernikahan</div>
          <div class="occasion-count">(1204 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/terima-kasih-N2Q5ZWQz.webp" class="occasion-image" alt="Ulang Tahun">
        <div class="occasion-info">
          <div class="occasion-title">Ulang Tahun</div>
          <div class="occasion-count">(2080 Pilihan)</div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/duka-cita-ZTg4NjllYz.webp" class="occasion-image" alt="Duka Cita">
        <div class="occasion-info">
          <div class="occasion-title">Duka Cita</div>
          <div class="occasion-count">(921 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/ucapan-selamat-YzlhY2.webp" class="occasion-image" alt="Imlek">
        <div class="occasion-info">
          <div class="occasion-title">Terima Kasih</div>
          <div class="occasion-count">(121 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/pernikahan-NWI3MDYy.webp" class="occasion-image" alt="Pernikahan">
        <div class="occasion-info">
          <div class="occasion-title">Pernikahan</div>
          <div class="occasion-count">(1204 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/terima-kasih-N2Q5ZWQz.webp" class="occasion-image" alt="Ulang Tahun">
        <div class="occasion-info">
          <div class="occasion-title">Ulang Tahun</div>
          <div class="occasion-count">(2080 Pilihan)</div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/duka-cita-ZTg4NjllYz.webp" class="occasion-image" alt="Duka Cita">
        <div class="occasion-info">
          <div class="occasion-title">Duka Cita</div>
          <div class="occasion-count">(921 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/ucapan-selamat-YzlhY2.webp" class="occasion-image" alt="Imlek">
        <div class="occasion-info">
          <div class="occasion-title">Terima Kasih</div>
          <div class="occasion-count">(121 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/pernikahan-NWI3MDYy.webp" class="occasion-image" alt="Pernikahan">
        <div class="occasion-info">
          <div class="occasion-title">Pernikahan</div>
          <div class="occasion-count">(1204 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/terima-kasih-N2Q5ZWQz.webp" class="occasion-image" alt="Ulang Tahun">
        <div class="occasion-info">
          <div class="occasion-title">Ulang Tahun</div>
          <div class="occasion-count">(2080 Pilihan)</div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/duka-cita-ZTg4NjllYz.webp" class="occasion-image" alt="Duka Cita">
        <div class="occasion-info">
          <div class="occasion-title">Duka Cita</div>
          <div class="occasion-count">(921 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/ucapan-selamat-YzlhY2.webp" class="occasion-image" alt="Imlek">
        <div class="occasion-info">
          <div class="occasion-title">Terima Kasih</div>
          <div class="occasion-count">(121 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/pernikahan-NWI3MDYy.webp" class="occasion-image" alt="Pernikahan">
        <div class="occasion-info">
          <div class="occasion-title">Pernikahan</div>
          <div class="occasion-count">(1204 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/terima-kasih-N2Q5ZWQz.webp" class="occasion-image" alt="Ulang Tahun">
        <div class="occasion-info">
          <div class="occasion-title">Ulang Tahun</div>
          <div class="occasion-count">(2080 Pilihan)</div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/duka-cita-ZTg4NjllYz.webp" class="occasion-image" alt="Duka Cita">
        <div class="occasion-info">
          <div class="occasion-title">Duka Cita</div>
          <div class="occasion-count">(921 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/ucapan-selamat-YzlhY2.webp" class="occasion-image" alt="Imlek">
        <div class="occasion-info">
          <div class="occasion-title">Terima Kasih</div>
          <div class="occasion-count">(121 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/pernikahan-NWI3MDYy.webp" class="occasion-image" alt="Pernikahan">
        <div class="occasion-info">
          <div class="occasion-title">Pernikahan</div>
          <div class="occasion-count">(1204 Pilihan)</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="occasion-item">
        <img src="https://www.delovery.com/images/icons/terima-kasih-N2Q5ZWQz.webp" class="occasion-image" alt="Ulang Tahun">
        <div class="occasion-info">
          <div class="occasion-title">Ulang Tahun</div>
          <div class="occasion-count">(2080 Pilihan)</div>
        </div>
      </div>
    </div>

    
  </div>
</div> -->
<div class="container mt-4">
  <h4>Pilih Penerima Spesial Anda</h4>

  <div class="slider-container">
    <button class="scroll-btn prev">
      <i class="fas fa-chevron-left"></i>
    </button>

    <div class="categories-wrapper">
      <div class="d-flex">
        <!-- Category items -->
        <div class="category-item" data-category="Pasangan">
          <div class="category-icon text-danger">
            <i class="fas fa-heart"></i>
          </div>
          <span>Pasangan</span>
        </div>

        <div class="category-item" data-category="Self Rewards">
          <div class="category-icon text-warning">
            <i class="fas fa-gift"></i>
          </div>
          <span>Self Rewards</span>
        </div>

        <div class="category-item" data-category="Partner Bisnis">
          <div class="category-icon text-primary">
            <i class="fas fa-handshake"></i>
          </div>
          <span>Partner Bisnis</span>
        </div>

        <div class="category-item" data-category="Teman">
          <div class="category-icon text-success">
            <i class="fas fa-users"></i>
          </div>
          <span>Teman</span>
        </div>

        <div class="category-item" data-category="Ibu">
          <div class="category-icon text-danger">
            <i class="fas fa-female"></i>
          </div>
          <span>Ibu</span>
        </div>

        <div class="category-item" data-category="Ayah">
          <div class="category-icon text-primary">
            <i class="fas fa-male"></i>
          </div>
          <span>Ayah</span>
        </div>

        <div class="category-item" data-category="Corporate">
          <div class="category-icon text-info">
            <i class="fas fa-building"></i>
          </div>
          <span>Corporate</span>
        </div>

      </div>
    </div>

    <button class="scroll-btn next">
      <i class="fas fa-chevron-right"></i>
    </button>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const profilWa = "{{ $profil->no_wa }}"; // Nomor WhatsApp dari backend Laravel

    const categoryItems = document.querySelectorAll('.category-item');

    categoryItems.forEach(item => {
      item.addEventListener('click', function() {
        const category = this.getAttribute('data-category');
        const message = `Saya ingin memesan produk atau katalog untuk penerima = ${category}.`;
        const whatsappUrl = `https://wa.me/${profilWa}?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank'); // Langsung buka WhatsApp
      });
    });
  });
</script>


<!-- Start Product Area -->
<div class="porduct-area section-pb" style="margin-top: 20px;">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">

        <div class="section-title text-center">
          <h2><span>Pilihan</span> Favorit Saat Ini</h2>
          <p>Menjadikan pilihanmu lebih beragam dan variatif sesuai dengan kebutuhan anda</p>
        </div>
      </div>
    </div>

    <div class="row product-two-row-4">


      @foreach ($produk as $p)
      <div class="col-lg-12">
        <!-- single-product-wrap start -->
        <div class="single-product-wrap">
          <div class="product-image">
            <a href="{{ route('katalog.katalog_detail', $p->slug) }}"><img src="/upload/products/{{ $p->image }}" alt="Produce Images"></a>
            <!-- <span class="label">30% Off</span> -->

            <a href="{{ route('katalog.katalog_detail', $p->slug) }}" class="add-to-cart" style="text-align: center;"> Detail</a>


          </div>
          <div class="product-content">
            <h3><a href="{{ route('katalog.katalog_detail', $p->slug) }}">{{ $p->name }}</a></h3>
            <div class="price-box">
              <!-- <span class="old-price">$56</span> -->
              <span class="new-price">Rp. {{ number_format($p->cost_price, 0, ',', '.') }}</span>
            </div>
          </div>
        </div>
        <!-- single-product-wrap end -->
      </div>
      @endforeach






    </div>
  </div>
</div>
<!-- Start Product End -->


<div class="container mb-3" style="margin-top: 20px;">
  <div class="row">
    <div class="col-lg-12">

      <div class="section-title text-center">
        <h2>Garansi Kualitas & Pengiriman Tepat Waktu</h2>
        <p>Kami telah dipercaya oleh banyak perusahaan berskala nasional maupun internasional</p>
      </div>
    </div>
  </div>
  <div class="custom-client-slider">
    <button class="custom-scroll-btn-client custom-prev-client">
      <i class="fas fa-chevron-left"></i>
    </button>

    <div class="custom-slider-client-wrapper">
      <div class="custom-client-list">
        <div class="custom-client-card">
          <img src="https://www.delovery.com/assets/images/company/JEC.webp" class="" alt="Bunga Papan">

        </div>

        <div class="custom-client-card">
          <img src="https://www.delovery.com/assets/images/company/BNI.webp" class="" alt="Parcel">

        </div>

        <div class="custom-client-card">
          <img src="https://www.delovery.com/assets/images/company/MANDIRI.webp" class="" alt="Hand Bouquet">
        </div>

        <div class="custom-client-card">
          <img src="https://www.delovery.com/assets/images/company/PERTAMINA.webp" class="" alt="Standing Flower">
        </div>

        <div class="custom-client-card">
          <img src="https://www.delovery.com/assets/images/company/SISI.webp" class="" alt="Cake & Pudding">
        </div>

        <div class="custom-client-card">
          <img src="https://www.delovery.com/assets/images/company/TIME.webp" class="" alt="Standing Paper Flower">
        </div>

        <div class="custom-client-card">
          <img src="https://www.delovery.com/assets/images/company/WINGS.webp" class="" alt="Table Bouquet">
        </div>

        <div class="custom-client-card">
          <img src="https://www.delovery.com/assets/images/company/YOUNG.webp" class="" alt="Money Gift">
        </div>


        <div class="custom-client-card">
          <img src="https://www.delovery.com/assets/images/company/ABC.webp" class="" alt="Parcel">
        </div>

        <div class="custom-client-card">
          <img src="https://www.delovery.com/assets/images/company/WIKA.webp" class="" alt="Hand Bouquet">
        </div>

        <div class="custom-client-card">
          <img src="https://www.delovery.com/assets/images/company/BCA.webp" class="" alt="Standing Flower">
        </div>

        <div class="custom-client-card">
          <img src="https://www.delovery.com/assets/images/company/DEKSON.webp" class="" alt="Cake & Pudding">
        </div>


      </div>
    </div>

    <button class="custom-scroll-btn-client custom-next-client">
      <i class="fas fa-chevron-right"></i>
    </button>
  </div>
</div>

<div class="container" style="background-color: #ff4444; margin-bottom:20px; padding:10px; border-radius:6px;">
  <div class="row">
    <div class="col-lg-12">

      <div class="section-title text-center">
        <h2 style="color:rgb(248, 245, 245); ">Hubungi Customer Service Kami</h2>
        <!-- <a href="" class="buy_now_btn" style="background-color: white; padding:10px; border-radius:5px; color: green; text-decoration: none; ">
          <i class="ion-social-whatsapp"></i> Chat Whatsapp
        </a> -->
        <a href="https://wa.me/{{ $profil->no_wa }}?text=Hallo%20Admin%20{{ $profil->nama_profil }},%20saya%20ingin%20menanyakan%20beberapa%20hal%20umum.%20Mohon%20informasikan%20lebih%20lanjut." target="_blank">
          <button class="buy_now_btn" type="button" style="padding: 10px 20px; background-color:rgb(27, 221, 75); color: white; border: none; border-radius: 5px; cursor: pointer;">
            <span><i class="ion-social-whatsapp"></i> Hubungi Via WhatsApp</span>
          </button>
        </a>

      </div>
    </div>
  </div>
</div>




<!-- Blog Area Start -->
<div class="blog-area" style="margin-bottom: 20px;">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">

        <div class="section-title text-center">
          <h2><span>Inspirasi</span> {{ $profil->nama_profil}}</h2>
          <p>Kamu bisa dapatkan berbagai macam inspirasi menarik dari monera, baik informasi umum, inovasi dan lain-lain</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6">
        <!-- single-blog Start -->
        <div class="single-blog mt-30">
          <div class="blog-image">
            <a href=""><img src="https://www.delovery.com/blog/wp-content/uploads/2017/03/manfaat-bunga-kamboja-768x432.webp" alt=""></a>
            <div class="meta-tag">
              <p><span>21</span> / Nov</p>
            </div>
          </div>

          <div class="blog-content">
            <h4><a href="">Lorem Ipsum available but majority</a></h4>
            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered in some ledmid form There are many majority have suffered </p>
            <div class="read-more">
              <a href="">READ MORE</a>
            </div>
          </div>
        </div>
        <!-- single-blog End -->
      </div>
      <div class="col-lg-6 col-md-6">
        <!-- single-blog Start -->
        <div class="single-blog mt-30">
          <div class="blog-image">
            <a href=""><img src="https://www.delovery.com/blog/wp-content/uploads/2017/04/jenis-bunga-lebih-indah-bunga-mawar-768x432.webp" alt=""></a>
            <div class="meta-tag">
              <p><span>26</span> / Nov</p>
            </div>
          </div>

          <div class="blog-content">
            <h4><a href="">Available but majority lorem Ipsum </a></h4>
            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered in some ledmid form There are many majority have suffered </p>
            <div class="read-more">
              <a href="">READ MORE</a>
            </div>
          </div>
        </div>
        <!-- single-blog End -->
      </div>
    </div>
  </div>
</div>
<!-- Blog Area End -->









<!-- Project Count Area Start -->
<div class="project-count-area section-pb section-pt-60"
  style="background-image: url('https://images.unsplash.com/photo-1687445665323-5767393970cc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8c3VtbWVyJTIwZmxvd2Vyc3xlbnwwfHwwfHx8MA%3D%3D'); background-size: cover; background-position: center; background-repeat: no-repeat;">

  <div class="container">
    <div class="project-count-inner_two">
      <div class="row">
        <div class="col-lg-12 ml-auto mr-auto">
          <div class="row">
            <div class="col-lg-4 col-sm-12">
              <div class="single-fun-factor">
                <!-- counter start -->
                <div class="counter text-center">
                  <h3><span class="counter-active">522</span>+</h3>
                  <p>Happy Customer</p>
                </div>
                <!-- counter end -->
              </div>
            </div>
            <div class="col-lg-4 col-sm-12">
              <div class="single-fun-factor">
                <!-- counter start -->
                <div class="counter text-center">
                  <h3><span class="counter-active">975</span>+</h3>
                  <p>Project Complete</p>
                </div>
                <!-- counter end -->
              </div>
            </div>
            <div class="col-lg-4 col-sm-12">
              <div class="single-fun-factor">
                <!-- counter start -->
                <div class="counter text-center">
                  <h3><span class="counter-active">9</span>+</h3>
                  <p>Years Experience</p>
                </div>
                <!-- counter end -->
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Project Count Area End -->



<!-- About Us Area -->
<!-- <div class="about-us-area" style="margin-bottom:20px; margin-top:20px;">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-7">
        <div class="about-us-contents">
          <h3>Kirim Sekarang, <span>Bayar Nanti.</span></h3>
          <p>Join member Corporate Delovery, dan nikmati mudahnya berkirim gift ke lebih dari 200 kota di seluruh Indonesia </p>
          <div class="about-us-btn">
            <a href="#">Join Sekarang</a>
          </div>
        </div>
      </div>
      <div class="col-lg-5 ">
        <div class="about-us-image text-right">
          <img src="https://images.unsplash.com/photo-1529636798458-92182e662485?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" alt="" style="border-radius: 25px;">
        </div>
      </div>
    </div>
  </div>
</div> -->
<!--// About Us Area -->


@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.querySelector('.categories-wrapper');
    const prevBtn = document.querySelector('.scroll-btn.prev');
    const nextBtn = document.querySelector('.scroll-btn.next');

    prevBtn.addEventListener('click', () => {
      wrapper.scrollBy({
        left: -200,
        behavior: 'smooth'
      });
    });

    nextBtn.addEventListener('click', () => {
      wrapper.scrollBy({
        left: 200,
        behavior: 'smooth'
      });
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.querySelector('.custom-slider-wrapper');
    const prevBtn = document.querySelector('.custom-scroll-btn.custom-prev');
    const nextBtn = document.querySelector('.custom-scroll-btn.custom-next');

    prevBtn.addEventListener('click', () => {
      wrapper.scrollBy({
        left: -240,
        behavior: 'smooth'
      });
    });

    nextBtn.addEventListener('click', () => {
      wrapper.scrollBy({
        left: 240,
        behavior: 'smooth'
      });
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.querySelector('.custom-slider-client-wrapper');
    const prevBtn = document.querySelector('.custom-scroll-btn-client.custom-prev-client');
    const nextBtn = document.querySelector('.custom-scroll-btn-client.custom-next-client');

    prevBtn.addEventListener('click', () => {
      wrapper.scrollBy({
        left: -240,
        behavior: 'smooth'
      });
    });

    nextBtn.addEventListener('click', () => {
      wrapper.scrollBy({
        left: 240,
        behavior: 'smooth'
      });
    });
  });
</script>