<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
  <meta name="keywords" content="{{$profil->keyword}}">
  <meta name="description" content="{{$profil->deskripsi_keyword}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="theme-color" content="#625AFA">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <!-- The above tags *must* come first in the head, any other head content must come *after* these tags -->
  <!-- Title -->
  <title>{{$title}}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap" rel="stylesheet">
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('/upload/profil/' . ($profil->favicon ?: 'https://static1.squarespace.com/static/524883b7e4b03fcb7c64e24c/524bba63e4b0bf732ffc8bce/646fb10bc178c30b7c6a31f2/1712669811602/Squarespace+Favicon.jpg?format=1500w')) }}">
  <!-- Apple Touch Icon -->
  <link rel="apple-touch-icon" href="{{ asset('template/front') }}/img/icons/icon-96x96.png">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('template/front') }}/img/icons/icon-152x152.png">
  <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('template/front') }}/img/icons/icon-167x167.png">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('template/front') }}/img/icons/icon-180x180.png">
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('template/front') }}/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('template/front') }}/css/tabler-icons.min.css">
  <link rel="stylesheet" href="{{ asset('template/front') }}/css/animate.css">
  <link rel="stylesheet" href="{{ asset('template/front') }}/css/owl.carousel.min.css">
  <link rel="stylesheet" href="{{ asset('template/front') }}/css/magnific-popup.css">
  <link rel="stylesheet" href="{{ asset('template/front') }}/css/nice-select.css">
  <!-- Stylesheet -->
  <link rel="stylesheet" href="{{ asset('template/front') }}/style.css">
  <!-- Web App Manifest -->
  <link rel="manifest" href="{{ asset('template/front') }}/manifest.json">
  <style>
    .sale-price-new {
      font-weight: bold;
    }

    .old-price {
      text-decoration: line-through;
      color: #999;
      /* Warna abu-abu agar terlihat beda */
      font-size: 0.9em;
      /* Ukuran sedikit lebih kecil */
      margin-left: 5px;
    }

    .custom-badge {
      display: inline-block;
      background-color: rgb(214, 60, 81);
      /* Warna biru (bisa diganti sesuai tema) */
      color: white;
      font-size: 12px;
      font-weight: bold;
      padding: 4px 10px;
      border-radius: 8px;
      margin-top: 5px;
      /* Agar ada jarak dari elemen di atasnya */
      text-align: center;
    }

    .product-note {
      font-style: italic;
      font-size: 0.875rem;
      /* Ukuran kecil (bisa disesuaikan) */
      color: #6c757d;
      /* Warna abu-abu agar lebih soft */
    }




    .product-card {
      height: 100%;
      /* Memastikan semua card memiliki tinggi yang sama */
      display: flex;
      flex-direction: column;
    }

    .product-card .card-body {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      /* Menjaga jarak elemen dalam card */
    }
  </style>
</head>

<body>
  <!-- Preloader-->
  <div class="preloader" id="preloader">
    <div class="spinner-grow text-secondary" role="status">
      <div class="sr-only"></div>
    </div>
  </div>
  <!-- Header Area -->
  <div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between d-flex rtl-flex-d-row-r">
      <!-- Logo Wrapper -->
      <div class="logo-wrapper"><a href="{{ asset('template/front') }}/home.html"><img src="{{ asset('/upload/profil/' . $profil->logo_dark) }}" alt=""></a></div>
      <div class="navbar-logo-container d-flex align-items-center">
        <!-- Cart Icon -->
        <div class="cart-icon-wrap"><a href="{{ asset('template/front') }}/cart.html"><i class="ti ti-basket-bolt"></i><span>13</span></a></div>
        <!-- User Profile Icon -->
        <div class="user-profile-icon ms-2"><a href="{{ asset('template/front') }}/profile.html"><img src="{{ asset('template/front') }}/img/bg-img/9.jpg" alt=""></a></div>
        <!-- Navbar Toggler -->
        <div class="suha-navbar-toggler ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas" aria-controls="suhaOffcanvas">
          <div><span></span><span></span><span></span></div>
        </div>
      </div>
    </div>
  </div>
  <div class="offcanvas offcanvas-start suha-offcanvas-wrap" tabindex="-1" id="suhaOffcanvas" aria-labelledby="suhaOffcanvasLabel">
    <!-- Close button-->
    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    <!-- Offcanvas body-->
    <div class="offcanvas-body">
      <!-- Sidenav Profile-->
      <div class="sidenav-profile">
        <div class="user-profile"><img src="{{ asset('template/front') }}/img/bg-img/9.jpg" alt=""></div>
        <div class="user-info">
          <h5 class="user-name mb-1 text-white">Suha Sarah</h5>
          <p class="available-balance text-white">Current Balance $<span class="counter">99</span></p>
        </div>
      </div>
      <!-- Sidenav Nav-->
      <ul class="sidenav-nav ps-0">
        <li><a href="{{ asset('template/front') }}/profile.html"><i class="ti ti-user"></i>My Profile</a></li>
        <li><a href="{{ asset('template/front') }}/notifications.html"><i class="ti ti-bell-ringing lni-tada-effect"></i>Notifications<span class="ms-1 badge badge-warning">3</span></a></li>
        <li class="suha-dropdown-menu"><a href="{{ asset('template/front') }}/#"><i class="ti ti-building-store"></i>Shop Pages</a>
          <ul>
            <li><a href="{{ asset('template/front') }}/shop-grid.html">Shop Grid</a></li>
            <li><a href="{{ asset('template/front') }}/shop-list.html">Shop List</a></li>
            <li><a href="{{ asset('template/front') }}/single-product.html">Product Details</a></li>
            <li><a href="{{ asset('template/front') }}/featured-products.html">Featured Products</a></li>
            <li><a href="{{ asset('template/front') }}/flash-sale.html">Flash Sale</a></li>
          </ul>
        </li>
        <li><a href="{{ asset('template/front') }}/pages.html"><i class="ti ti-notebook"></i>All Pages</a></li>
        <li class="suha-dropdown-menu"><a href="{{ asset('template/front') }}/wishlist-grid.html"><i class="ti ti-heart"></i>My Wishlist</a>
          <ul>
            <li><a href="{{ asset('template/front') }}/wishlist-grid.html">Wishlist Grid</a></li>
            <li><a href="{{ asset('template/front') }}/wishlist-list.html">Wishlist List</a></li>
          </ul>
        </li>
        <li><a href="{{ asset('template/front') }}/settings.html"><i class="ti ti-adjustments-horizontal"></i>Settings</a></li>
        <li><a href="{{ asset('template/front') }}/intro.html"><i class="ti ti-logout"></i>Sign Out</a></li>
      </ul>
    </div>
  </div>
  <!-- PWA Install Alert -->
  <div class="toast pwa-install-alert shadow bg-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" data-bs-autohide="true">
    <div class="toast-body">
      <div class="content d-flex align-items-center mb-2"><img src="{{ asset('template/front') }}/img/icons/icon-72x72.png" alt="">
        <h6 class="mb-0">Add to Home Screen</h6>
        <button class="btn-close ms-auto" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
      </div><span class="mb-0 d-block">Click the<strong class="mx-1">Add to Home Screen</strong>button &amp; enjoy it like a regular app.</span>
    </div>
  </div>



  @yield('content')



  <!-- Internet Connection Status-->
  <div class="internet-connection-status" id="internetStatus"></div>
  <!-- Footer Nav-->
  <div class="footer-nav-area" id="footerNav">
    <div class="suha-footer-nav">
      <ul class="h-100 d-flex align-items-center justify-content-between ps-0 d-flex rtl-flex-d-row-r">
        <li><a href="{{ asset('template/front') }}/home.html"><i class="ti ti-home"></i>Beranda</a></li>
        <li><a href="{{ asset('template/front') }}/message.html"><i class="ti ti-building-store"></i>Produk</a></li>
        <li><a href="{{ asset('template/front') }}/cart.html"><i class="ti ti-notebook"></i>Layanan</a></li>
        <li><a href="{{ asset('template/front') }}/settings.html"><i class="ti ti-news"></i>Blog</a></li>
        <li><a href="{{ asset('template/front') }}/pages.html"><i class="ti ti-login"></i>Login</a></li>
      </ul>
    </div>
  </div>
  <!-- All JavaScript Files-->
  <script src="{{ asset('template/front') }}/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('template/front') }}/js/jquery.min.js"></script>
  <script src="{{ asset('template/front') }}/js/waypoints.min.js"></script>
  <script src="{{ asset('template/front') }}/js/jquery.easing.min.js"></script>
  <script src="{{ asset('template/front') }}/js/owl.carousel.min.js"></script>
  <script src="{{ asset('template/front') }}/js/jquery.magnific-popup.min.js"></script>
  <script src="{{ asset('template/front') }}/js/jquery.counterup.min.js"></script>
  <script src="{{ asset('template/front') }}/js/jquery.countdown.min.js"></script>
  <script src="{{ asset('template/front') }}/js/jquery.passwordstrength.js"></script>
  <script src="{{ asset('template/front') }}/js/jquery.nice-select.min.js"></script>
  <script src="{{ asset('template/front') }}/js/theme-switching.js"></script>
  <script src="{{ asset('template/front') }}/js/no-internet.js"></script>
  <script src="{{ asset('template/front') }}/js/active.js"></script>
  <script src="{{ asset('template/front') }}/js/pwa.js"></script>
</body>

</html>