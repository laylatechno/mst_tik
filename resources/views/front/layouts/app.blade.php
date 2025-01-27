<!doctype html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{ $title }}</title>
  <meta name="robots" content="noindex, follow" />
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="{{ asset('/upload/profil/' . ($profil->favicon ?: 'https://static1.squarespace.com/static/524883b7e4b03fcb7c64e24c/524bba63e4b0bf732ffc8bce/646fb10bc178c30b7c6a31f2/1712669811602/Squarespace+Favicon.jpg?format=1500w')) }}" />


  <!-- CSS
	============================================ -->

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('template/front') }}/assets/css/vendor/bootstrap.min.css">

  <!-- Icon Font CSS -->
  <link rel="stylesheet" href="{{ asset('template/front') }}/assets/css/vendor/ionicons.min.css">

  <!-- Plugins CSS -->
  <link rel="stylesheet" href="{{ asset('template/front') }}/assets/css/plugins/slick.css">
  <link rel="stylesheet" href="{{ asset('template/front') }}/assets/css/plugins/animation.css">
  <link rel="stylesheet" href="{{ asset('template/front') }}/assets/css/plugins/jqueryui.min.css">

  <!-- Vendor & Plugins CSS (Please remove the comment from below vendor.min.css & plugins.min.css for better website load performance and remove css files from avobe) -->
  <!--
    <script src="{{ asset('template/front') }}/assets/js/vendor/vendor.min.js"></script>
    <script src="{{ asset('template/front') }}/assets/js/plugins/plugins.min.js"></script>
    -->

  <!-- Main Style CSS (Please use minify version for better website load performance) -->
  <link rel="stylesheet" href="{{ asset('template/front') }}/assets/css/style.css">
  <!--<link rel="stylesheet" href="{{ asset('template/front') }}/assets/css/style.min.css">-->

  <!-- CSS -->
  <style>
    .whatsapp-float {
      position: fixed;
      bottom: 120px;
      /* Menaikkan posisi lebih tinggi */
      right: 20px;
      background-color: #25d366;
      /* WhatsApp green color */
      color: white;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      /* Ensure it stays above other elements */
      text-decoration: none;
      font-size: 24px;
    }

    .whatsapp-float:hover {
      background-color: #1da851;
      color: white;
      transform: scale(1.1);
      /* Slightly increase size on hover */
      transition: 0.3s ease-in-out;
    }
  </style>

</head>

<body>

  <div class="main-wrapper">

    <header class="fl-header">

      <!-- Header Top Start -->
      <div class="header-top-area d-none d-lg-block">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="header-top-inner">
                <div class="row">
                  <div class="col-lg-4 col-md-3">
                    <div class="social-top">
                      <ul>
                        <li><a href="{{$profil->facebook }}"><i class="ion-social-facebook"></i></a></li>
                        <li><a href="{{$profil->twitter }}"><i class="ion-social-twitter"></i></a></li>
                        <li><a href="{{$profil->instagram }}"><i class="ion-social-instagram"></i></a></li>
                        <li><a href="{{$profil->youtube }}"><i class="ion-social-youtube"></i></a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-lg-8 col-md-9">
                    <div class="top-info-wrap text-right">
                      <ul class="top-info">
                        <li>Senis - Jumat : 09:00-17:00 WIB </li>
                        <li><a href="">{{$profil->no_telp }}</a></li>
                        <li><a href="{{$profil->email }}">{{$profil->email }}</a></li>
                      </ul>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Header Top End -->

      <!-- haeader bottom Start -->
      <div class="haeader-bottom-area">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-2 col-md-4 col-5">
              <div class="logo-area">
                <a href="/"><img src="{{ asset('/upload/profil/' . $profil->logo) }}" alt=""></a>
              </div>
            </div>
            <div class="col-lg-8 d-none d-lg-block">
              <div class="main-menu-area text-center">
                <!--  Start Mainmenu Nav-->
                <nav class="main-navigation">
                  <ul>
                    <!-- <li class="active"><a href="/">Home</a>
                                            <ul class="sub-menu">
                                                <li><a href="/">Home Page One</a></li>
                                                <li><a href="{{ asset('template/front') }}/index-2.html">Home Page Two</a></li>
                                                <li><a href="{{ asset('template/front') }}/index-box.html">Home Boxed Layout 1</a></li>
                                                <li><a href="{{ asset('template/front') }}/index-2-box.html">Home Boxed Layout 2</a></li>
                                            </ul>
                                        </li> -->
                    <li><a href="/katalog">Katalog</a>
                      <ul class="mega-menu">
                        <li><a href="">Tersedia</a>
                          <ul>
                            <li><a href="#" data-item="Parcel Idul Fitri">Parcel Idul Fitri</a></li>
                            <li><a href="#" data-item="Parcel Natal">Parcel Natal</a></li>
                            <li><a href="#" data-item="Parcel Imlek">Parcel Imlek</a></li>
                            <li><a href="#" data-item="Parcel Anak">Parcel Anak</a></li>
                            <li><a href="#" data-item="Hampers Newborn">Hampers Newborn</a></li>
                          </ul>
                        </li>
                        <script>
                          document.addEventListener('DOMContentLoaded', function() {
                            const profilNama = "{{ $profil->nama_profil }}"; // Nama profil dari backend Laravel
                            const profilWa = "{{ $profil->no_wa }}"; // Nomor WhatsApp dari backend Laravel

                            const menuLinks = document.querySelectorAll('ul a[data-item]');

                            menuLinks.forEach(link => {
                              link.addEventListener('click', function(event) {
                                event.preventDefault();
                                const item = this.getAttribute('data-item');
                                const message = `Hallo Admin ${profilNama}, saya ingin memesan ${item}.`;
                                const whatsappUrl = `https://wa.me/${profilWa}?text=${encodeURIComponent(message)}`;
                                window.open(whatsappUrl, '_blank');
                              });
                            });
                          });
                        </script>

                        <!-- <li><a href=" ">Karangan Bunga Papan</a>
                          <ul>
                            <li><a href=" ">Karangan Bunga Papan Pernikahan</a></li>
                            <li><a href="">Karangan Bunga Papan Duka Cita</a></li>
                            <li><a href="">Karangan Bunga Papan Ucapan Selamat</a></li>
                            <li><a href="">Bunga Standing Flower</a></li>
                            <li><a href="">Papan Bunga Kertas</a></li>
                            <li><a href="">Papan Bunga Akrilik</a></li>
                            <li><a href="">Standing Flower Kertas</a></li>
                          </ul>
                        </li>
                        <li><a href="">Kado & Cakes</a>
                          <ul>
                            <li><a href="">Hampers & Cookies</a></li>
                            <li><a href="">Parcel</a></li>
                            <li><a href="">Parcel Buah</a></li>
                            <li><a href="">Parcel Makanan</a></li>
                            <li><a href="">Parcel Kesehatan</a></li>
                            <li><a href="">Parcel Pecah Belah</a></li>
                            <li><a href="">Cake & Pudding</a></li>
                            <li><a href="">Hampers Baby Born</a></li>
                            <li><a href="">Personalized Gift</a></li>
                          </ul>
                        </li> -->
                      </ul>
                    </li>
                    <li><a href="">Momen</a>
                      <ul class="mega-menu">
                        <li><a href="/">Semua Momen</a>
                          <ul>
                            <li><a href="#" data-tema="Duka Cita">Duka Cita</a></li>
                            <li><a href="#" data-tema="Imlek">Imlek</a></li>
                            <li><a href="#" data-tema="Pernikahan">Pernikahan</a></li>
                            <li><a href="#" data-tema="Ulang Tahun">Ulang Tahun</a></li>
                            <li><a href="#" data-tema="Ucapan Selamat">Ucapan Selamat</a></li>
                            <li><a href="#" data-tema="Pembukaan Toko">Pembukaan Toko</a></li>
                            <li><a href="#" data-tema="Valentine">Valentine</a></li>
                          </ul>
                        </li>
                        <li style="padding-top: 40px;">
                          <ul>
                            <li><a href="#" data-tema="Hari Ibu">Hari Ibu</a></li>
                            <li><a href="#" data-tema="Kelahiran">Kelahiran</a></li>
                            <li><a href="#" data-tema="Mid-Autumn Festival">Mid-Autumn Festival</a></li>
                            <li><a href="#" data-tema="Cepat Sembuh">Cepat Sembuh</a></li>
                            <li><a href="#" data-tema="Lamaran/Tunangan">Lamaran/Tunangan</a></li>
                            <li><a href="#" data-tema="Permintaan Maaf">Permintaan Maaf</a></li>
                            <li><a href="#" data-tema="Wisuda">Wisuda</a></li>
                          </ul>
                        </li>
                        <li style="padding-top: 40px;">
                          <ul>
                            <li><a href="#" data-tema="Anniversary">Anniversary</a></li>
                            <li><a href="#" data-tema="Terima Kasih">Terima Kasih</a></li>
                            <li><a href="#" data-tema="Romantis">Romantis</a></li>
                            <li><a href="#" data-tema="Hari Ayah">Hari Ayah</a></li>
                            <li><a href="#" data-tema="Lebaran">Lebaran</a></li>
                            <li><a href="#" data-tema="Natal">Natal</a></li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                    <script>
                      document.addEventListener('DOMContentLoaded', function() {
                        const profilNama = "{{ $profil->nama_profil }}"; // Nama profil
                        const profilWa = "{{ $profil->no_wa }}"; // Nomor WhatsApp

                        document.querySelectorAll('.mega-menu a[data-tema]').forEach(function(link) {
                          link.addEventListener('click', function(e) {
                            e.preventDefault(); // Mencegah aksi default klik

                            const tema = this.dataset.tema; // Mendapatkan tema dari atribut data
                            const whatsappLink = `https://wa.me/${profilWa}?text=Hallo%20Admin%20${encodeURIComponent(profilNama)}%20saya%20ingin%20memesan%20dengan%20tema%20${encodeURIComponent(tema)}`;

                            window.open(whatsappLink, '_blank'); // Membuka tautan di tab baru
                          });
                        });
                      });
                    </script>

                    <li><a href="/">Lokasi</a>
                      <ul class="sub-menu">
                        <li><a href="#" data-lokasi="Kota Tasikmalaya">Kota Tasikmalaya</a></li>
                        <li><a href="#" data-lokasi="Kab Tasikmalaya">Kab Tasikmalaya</a></li>
                        <li><a href="#" data-lokasi="Kab Ciamis">Kab Ciamis</a></li>
                        <li><a href="#" data-lokasi="Kab Garut">Kab Garut</a></li>
                        <li><a href="#" data-lokasi="Kota Banjar">Kota Banjar</a></li>
                        <li><a href="#" data-lokasi="Kab Pangandaran">Kab Pangandaran</a></li>
                      </ul>
                    </li>

                    <script>
                      document.addEventListener('DOMContentLoaded', function() {
                        const profilNama = "{{ $profil->nama_profil }}"; // Nama profil dari backend Laravel
                        const profilWa = "{{ $profil->no_wa }}"; // Nomor WhatsApp dari backend Laravel

                        const menuLinks = document.querySelectorAll('.sub-menu a[data-lokasi]');

                        menuLinks.forEach(link => {
                          link.addEventListener('click', function(event) {
                            event.preventDefault();
                            const lokasi = this.getAttribute('data-lokasi');
                            const message = `Hallo Admin ${profilNama}, saya ingin memesan untuk daerah ${lokasi}.`;
                            const whatsappUrl = `https://wa.me/${profilWa}?text=${encodeURIComponent(message)}`;
                            window.open(whatsappUrl, '_blank');
                          });
                        });
                      });
                    </script>



                    <li><a href="/testimoni">Testimoni</a></li>
                    <!-- <li><a href="{{ asset('template/front') }}/blog.html">Blog</a>
                                            <ul class="sub-menu">
                                                <li><a href="{{ asset('template/front') }}/blog.html">Blog Left Sidebar</a></li>
                                                <li><a href="{{ asset('template/front') }}/blog-right.html">Blog Right Sidebar</a></li>
                                                <li><a href="{{ asset('template/front') }}/blog-details.html">Blog Details Page</a></li>
                                            </ul>
                                        </li> -->
                    <!-- <li><a href="{{ asset('template/front') }}/contact-us.html">Contact</a></li> -->
                  </ul>
                </nav>

              </div>
            </div>

            <div class="col-lg-2 col-md-8 col-7">
              <div class="right-blok-box d-flex">
                <!-- <div class="search-wrap">
                                    <a href="/" class="trigger-search"><i class="ion-ios-search-strong"></i></a>
                                </div> -->




                <div class="shopping-cart-wrap">
                  <a
                    href="https://wa.me/{{ $profil->no_wa }}?text={{ urlencode('Hallo Admin '.$profil->nama_profil.', saya ingin bertanya terkait katalog dan layanan di '.$profil->nama_profil.'. Terima kasih') }}"
                    title="Hubungi Via WhatsApp"
                    target="_blank">
                    <i class="ion-social-whatsapp-outline"></i>
                  </a>

                  <!-- <ul class="mini-cart">
                                        <li class="cart-item">
                                            <div class="cart-image">
                                                <a href="{{ asset('template/front') }}/product-details.html"><img alt="" src="{{ asset('template/front') }}/assets/images/product/product-01.jpg"></a>
                                            </div>
                                            <div class="cart-title">
                                                <a href="{{ asset('template/front') }}/product-details.html">
                                                    <h4>Product Name 01</h4>
                                                </a>
                                                <span class="quantity">1 ×</span>
                                                <div class="price-box"><span class="new-price">$130.00</span></div>
                                                <a class="remove_from_cart" href="/"><i class="icon-trash icons"></i></a>
                                            </div>
                                        </li>
                                        <li class="cart-item">
                                            <div class="cart-image">
                                                <a href="{{ asset('template/front') }}/product-details.html"><img alt="" src="{{ asset('template/front') }}/assets/images/product/product-02.jpg"></a>
                                            </div>
                                            <div class="cart-title">
                                                <a href="{{ asset('template/front') }}/product-details.html">
                                                    <h4>Product Name 03</h4>
                                                </a>
                                                <span class="quantity">1 ×</span>
                                                <div class="price-box"><span class="new-price">$130.00</span></div>
                                                <a class="remove_from_cart" href="/"><i class="icon-trash icons"></i></a>
                                            </div>
                                        </li>
                                        <li class="subtotal-titles">
                                            <div class="subtotal-titles">
                                                <h3>Sub-Total :</h3><span>$ 230.99</span>
                                            </div>
                                        </li>
                                        <li class="mini-cart-btns">
                                            <div class="cart-btns">
                                                <a href="{{ asset('template/front') }}/cart.html">View cart</a>
                                                <a href="{{ asset('template/front') }}/checkout.html">Checkout</a>
                                            </div>
                                        </li>
                                    </ul> -->
                </div>

                <!-- <div class="user-wrap">
                  <a href="{{ asset('template/front') }}/wishlist.html"><i class="ion-ios-person"></i></a>
                </div> -->


                <div class="mobile-menu-btn d-block d-lg-none">
                  <div class="off-canvas-btn">
                    <i class="ion-android-menu"></i>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- haeader bottom End -->

      <!-- main-search start -->
      <div class="main-search-active">
        <div class="sidebar-search-icon">
          <button class="search-close"><span class="ion-android-close"></span></button>
        </div>
        <div class="sidebar-search-input">
          <form>
            <div class="form-search">
              <input id="search" class="input-text" value="" placeholder="Search entire store here ..." type="search">
              <button class="search-btn" type="button">
                <i class="ion-ios-search"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
      <!-- main-search start -->


      <!-- off-canvas menu start -->
      <aside class="off-canvas-wrapper">
        <div class="off-canvas-overlay"></div>
        <div class="off-canvas-inner-content">
          <div class="btn-close-off-canvas">
            <i class="ion-android-close"></i>
          </div>

          <div class="off-canvas-inner">

            <!-- mobile menu start -->
            <div class="mobile-navigation">

              <!-- mobile menu navigation start -->
              <nav>
                <ul class="mobile-menu">
                  <li class="menu-item-has-children"><a href="/">Katalog</a>
                    <ul class="dropdown">
                      <li><a href="#" data-item="Parcel Idul Fitri">Parcel Idul Fitri</a></li>
                      <li><a href="#" data-item="Parcel Natal">Parcel Natal</a></li>
                      <li><a href="#" data-item="Parcel Imlek">Parcel Imlek</a></li>
                      <li><a href="#" data-item="Parcel Anak">Parcel Anak</a></li>
                      <li><a href="#" data-item="Hampers Newborn">Hampers Newborn</a></li>
                    </ul>
                  </li>
                  <script>
                    document.addEventListener('DOMContentLoaded', function() {
                      const profilNama = "{{ $profil->nama_profil }}"; // Nama profil dari backend Laravel
                      const profilWa = "{{ $profil->no_wa }}"; // Nomor WhatsApp dari backend Laravel

                      const menuLinks = document.querySelectorAll('ul a[data-item]');

                      menuLinks.forEach(link => {
                        link.addEventListener('click', function(event) {
                          event.preventDefault();
                          const item = this.getAttribute('data-item');
                          const message = `Hallo Admin ${profilNama}, saya ingin memesan ${item}.`;
                          const whatsappUrl = `https://wa.me/${profilWa}?text=${encodeURIComponent(message)}`;
                          window.open(whatsappUrl, '_blank');
                        });
                      });
                    });
                  </script>
                  <li class="menu-item-has-children"><a href="/">Momen</a>
                    <ul class="megamenu dropdown">

                      <li><a href="#" data-tema="Duka Cita">Duka Cita</a></li>
                      <li><a href="#" data-tema="Imlek">Imlek</a></li>
                      <li><a href="#" data-tema="Pernikahan">Pernikahan</a></li>
                      <li><a href="#" data-tema="Ulang Tahun">Ulang Tahun</a></li>
                      <li><a href="#" data-tema="Ucapan Selamat">Ucapan Selamat</a></li>
                      <li><a href="#" data-tema="Pembukaan Toko">Pembukaan Toko</a></li>
                      <li><a href="#" data-tema="Valentine">Valentine</a></li>

                      <li><a href="#" data-tema="Hari Ibu">Hari Ibu</a></li>
                      <li><a href="#" data-tema="Kelahiran">Kelahiran</a></li>
                      <li><a href="#" data-tema="Mid-Autumn Festival">Mid-Autumn Festival</a></li>
                      <li><a href="#" data-tema="Cepat Sembuh">Cepat Sembuh</a></li>
                      <li><a href="#" data-tema="Lamaran/Tunangan">Lamaran/Tunangan</a></li>
                      <li><a href="#" data-tema="Permintaan Maaf">Permintaan Maaf</a></li>
                      <li><a href="#" data-tema="Wisuda">Wisuda</a></li>

                      <li><a href="#" data-tema="Anniversary">Anniversary</a></li>
                      <li><a href="#" data-tema="Terima Kasih">Terima Kasih</a></li>
                      <li><a href="#" data-tema="Romantis">Romantis</a></li>
                      <li><a href="#" data-tema="Hari Ayah">Hari Ayah</a></li>
                      <li><a href="#" data-tema="Lebaran">Lebaran</a></li>
                      <li><a href="#" data-tema="Natal">Natal</a></li>

                    </ul>
                  </li>
                  <script>
                    document.addEventListener('DOMContentLoaded', function() {
                      const profilNama = "{{ $profil->nama_profil }}"; // Nama profil
                      const profilWa = "{{ $profil->no_wa }}"; // Nomor WhatsApp

                      document.querySelectorAll('.mega-menu a[data-tema]').forEach(function(link) {
                        link.addEventListener('click', function(e) {
                          e.preventDefault(); // Mencegah aksi default klik

                          const tema = this.dataset.tema; // Mendapatkan tema dari atribut data
                          const whatsappLink = `https://wa.me/${profilWa}?text=Hallo%20Admin%20${encodeURIComponent(profilNama)}%20saya%20ingin%20memesan%20dengan%20tema%20${encodeURIComponent(tema)}`;

                          window.open(whatsappLink, '_blank'); // Membuka tautan di tab baru
                        });
                      });
                    });
                  </script>

                  <li class="menu-item-has-children"><a href="/">Lokasi</a>
                    <ul class="dropdown">
                      <li><a href="#" data-lokasi="Kota Tasikmalaya">Kota Tasikmalaya</a></li>
                      <li><a href="#" data-lokasi="Kab Tasikmalaya">Kab Tasikmalaya</a></li>
                      <li><a href="#" data-lokasi="Kab Ciamis">Kab Ciamis</a></li>
                      <li><a href="#" data-lokasi="Kab Garut">Kab Garut</a></li>
                      <li><a href="#" data-lokasi="Kota Banjar">Kota Banjar</a></li>
                      <li><a href="#" data-lokasi="Kab Pangandaran">Kab Pangandaran</a></li>
                    </ul>
                  </li>
                  <script>
                    document.addEventListener('DOMContentLoaded', function() {
                      const profilNama = "{{ $profil->nama_profil }}"; // Nama profil dari backend Laravel
                      const profilWa = "{{ $profil->no_wa }}"; // Nomor WhatsApp dari backend Laravel

                      const menuLinks = document.querySelectorAll('.sub-menu a[data-lokasi]');

                      menuLinks.forEach(link => {
                        link.addEventListener('click', function(event) {
                          event.preventDefault();
                          const lokasi = this.getAttribute('data-lokasi');
                          const message = `Hallo Admin ${profilNama}, saya ingin memesan untuk daerah ${lokasi}.`;
                          const whatsappUrl = `https://wa.me/${profilWa}?text=${encodeURIComponent(message)}`;
                          window.open(whatsappUrl, '_blank');
                        });
                      });
                    });
                  </script>
                  <li><a href="/testimoni">Testimoni</a></li>
                </ul>
              </nav>
              <!-- mobile menu navigation end -->
            </div>
            <!-- mobile menu end -->



            <!-- offcanvas widget area start -->
            <div class="offcanvas-widget-area">
              <div class="off-canvas-contact-widget">
                <ul>
                  <li>Senis - Jumat : 09:00-17:00 WIB </li>
                  <li><a href="">{{$profil->no_telp }}</a></li>
                  <li><a href="{{$profil->email }}">{{$profil->email }}</a></li>
                </ul>
              </div>
              <div class="off-canvas-social-widget">
             <a href="{{$profil->facebook }}"><i class="ion-social-facebook"></i></a>
                       <a href="{{$profil->twitter }}"><i class="ion-social-twitter"></i></a>
                       <a href="{{$profil->instagram }}"><i class="ion-social-instagram"></i></a>
                       <a href="{{$profil->youtube }}"><i class="ion-social-youtube"></i></a>
         
              </div>

            </div>
            <!-- offcanvas widget area end -->
          </div>
        </div>
      </aside>
      <!-- off-canvas menu end -->


    </header>

    @yield('content')

    <!-- WhatsApp Floating Button -->
    <a
      href="https://wa.me/{{ $profil->no_wa }}?text={{ urlencode('Halo ' . $profil->nama_profil . ', Saya ingin pesan rangkaian bunga / Gift di Delovery dengan mudah dan cepat. Bisa dibantu?') }}"
      class="whatsapp-float"
      target="_blank" title="Chat WhatsApp">
      <i class="ion-social-whatsapp"></i>
    </a>
    <footer>
      <div class="footer-top section-pb section-pt-60">
        <div class="container">
          <div class="row">
            <div class="col-lg-4 col-md-6">
              <div class="widget-footer mt-20">
                <div class="footer-logo">
                  <a href="/"><img src="{{ asset('/upload/profil/' . $profil->logo) }}" alt=""></a>
                </div>
                <p>{{ $profil->nama_profil }} berkomitmen untuk memberikan kualitas dan layanan terbaik untuk menyempurnakan ungkapan kasih dan ucapan Anda.</p>
                <div class="newsletter-footer">
                  <input type="text" id="emailInput" placeholder="Email Anda">
                  <div class="subscribe-button">
                    <button class="subscribe-btn" id="subscribeBtn">Subscribe</button>
                  </div>
                </div>

                <script>
                  document.getElementById('subscribeBtn').addEventListener('click', function() {
                    var email = document.getElementById('emailInput').value;
                    var profilNama = "{{ $profil->nama_profil }}"; // Nama profil dari backend Laravel
                    var message = `Halo Admin ${profilNama}, saya ingin mendapatkan informasi terbaru. Email saya: ${email}`;
                    var whatsappUrl = `https://wa.me/{{ $profil->no_wa }}?text=${encodeURIComponent(message)}`;
                    window.open(whatsappUrl, '_blank');
                  });
                </script>

              </div>
            </div>
            <div class="col-lg-2 col-md-6">
              <div class="widget-footer mt-30">
                <h6 class="title-widget">Informasi</h6>
                <ul class="footer-list">
                  <li><a href="/">Tentang Kami</a></li>
                  <li><a href="/">Inspirasi</a></li>
                  <li><a href="/">Daerah Pengiriman</a></li>
                  <li><a href="/">FAQ</a></li>
                  <li><a href="/">Syarat & Ketentuan</a></li>
                  <li><a href="/">Privacy Policy</a></li>

                </ul>
              </div>
            </div>
            <div class="col-lg-2 col-md-6">
              <div class="widget-footer mt-30">
                <h6 class="title-widget">{{ $profil->nama_profil }}</h6>
                <ul class="footer-list">
                  <li><a href="/">Toko Bunga Online</a></li>
                  <li><a href="/">Toko Kado Online</a></li>
                  <li><a href="/">Buket Bunga</a></li>
                  <li><a href="/">Bunga Papan</a></li>
                  <li><a href="/">Hamper</a></li>
                  <li><a href="/">Parcel</a></li>
                  <li><a href="/">Occasian</a></li>

                </ul>
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="widget-footer mt-30">
                <h6 class="title-widget">Kontak</h6>
                <ul class="footer-contact">
                  <li>
                    <label>WhatsApp</label>
                    <a
                      href="https://wa.me/{{ $profil->no_wa }}?text={{ urlencode('Halo ' . $profil->nama_profil . ', Saya ingin pesan rangkaian bunga / Gift di Delovery dengan mudah dan cepat. Bisa dibantu?') }}"
                      target="_blank">
                      {{ $profil->no_wa }}
                    </a>
                  </li>

                  <li>
                    <label>Email</label>
                    <a href="#">{{ $profil->email}}</a>
                  </li>
                  <li>
                    <label>Alamat</label>
                    {{ $profil->alamat}}
                  </li>
                </ul>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="copy-right-text text-center">
                <p>Copyright &copy; <a href="/">{{ $profil->nama_profil }}</a> {{ date('Y') }}. All Rights Reserved</p>

              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>



  </div>

  <!-- JS
============================================ -->

  <!-- Modernizer JS -->
  <script src="{{ asset('template/front') }}/assets/js/vendor/modernizr-3.6.0.min.js"></script>
  <!-- jQuery JS -->
  <script src="{{ asset('template/front') }}/assets/js/vendor/jquery-3.3.1.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="{{ asset('template/front') }}/assets/js/vendor/popper.min.js"></script>
  <script src="{{ asset('template/front') }}/assets/js/vendor/bootstrap.min.js"></script>

  <!-- Slick Slider JS -->
  <script src="{{ asset('template/front') }}/assets/js/plugins/slick.min.js"></script>
  <!--  Jquery ui JS -->
  <script src="{{ asset('template/front') }}/assets/js/plugins/jqueryui.min.js"></script>
  <!--  Scrollup JS -->
  <script src="{{ asset('template/front') }}/assets/js/plugins/scrollup.min.js"></script>
  <script src="{{ asset('template/front') }}/assets/js/plugins/ajax-contact.js"></script>

  <!-- Vendor & Plugins JS (Please remove the comment from below vendor.min.js & plugins.min.js for better website load performance and remove js files from avobe) -->
  <!--
<script src="{{ asset('template/front') }}/assets/js/vendor/vendor.min.js"></script>
<script src="{{ asset('template/front') }}/assets/js/plugins/plugins.min.js"></script>
-->

  <!-- Main JS -->
  <script src="{{ asset('template/front') }}/assets/js/main.js"></script>

</body>

</html>