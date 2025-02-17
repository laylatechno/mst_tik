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
    .lazy-img {
      filter: blur(10px);
      transition: filter 0.3s ease-in-out;
    }

    .lazy-img.loaded {
      filter: blur(0);
    }
  </style>
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

    .store-badge {
      display: inline-block;
      background-color: rgb(106, 60, 214);
      /* Warna biru (bisa diganti sesuai tema) */
      color: white;
      font-size: 12px;
      font-weight: bold;
      padding: 4px 10px;
      border-radius: 8px;
      margin-top: 5px;
      margin-bottom: 5px;
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




    .pagination-two .page-link {
      color: black !important;
      /* Ubah warna teks menjadi merah */
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
      <div class="logo-wrapper">
        <a href="/">
          <img id="logoImage"
            src="{{ asset('/upload/profil/' . $profil->logo) }}"
            alt="Logo"
            data-light="{{ asset('/upload/profil/' . $profil->logo) }}"
            data-dark="{{ asset('/upload/profil/' . $profil->logo_dark) }}">
        </a>
      </div>

      <div class="navbar-logo-container d-flex align-items-center">
        <!-- Cart Icon -->
        <!-- <div class="cart-icon-wrap"><a href="/"><i class="ti ti-basket-bolt"></i><span>13</span></a></div> -->

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
        
        <div class="user-profile">
          <br>
          <img id="logoImage"
            src="{{ asset('/upload/profil/' . $profil->logo_dark) }}"
            alt="Logo"></div>
        <div class="user-info">
          <h5 class="user-name mb-1 text-white">{{ $profil->nama_profil }}</h5>
          <span style="color: white; font-size:12px;">{{ $profil->alamat }}</span>
          <br>
          <p class="available-balance text-white">{{ $profil->email }}</p>
          <p class="available-balance text-white">{{ $profil->no_telp }}</p>
          <br>
          <p class="available-balance text-white"><i class="ti ti-building-store"></i></p>
          <p class="available-balance text-white"><i class="ti ti-building-store"></i></p>
        </div>
      </div>
      <!-- Sidenav Nav-->
      <ul class="sidenav-nav ps-0">
        <li><a href="/"><i class="ti ti-home"></i>Beranda</a></li>
        <li><a href="/"><i class="ti ti-bell-ringing lni-tada-effect"></i>Informasi Penting<span class="ms-1 badge badge-warning">3</span></a></li>
        <li><a href="/toko"><i class="ti ti-building-store"></i>Toko</a></li>
        <li>
          @php
          $no_wa = str_replace(['-', ' ', '+'], '', $profil->no_wa); // Menghapus tanda tambah (+), spasi, dan tanda hubung jika ada
          $pesan =
          'Hallo.. !! Apakah berkenan saya bertanya terkait informasi tentang ' .
          $profil->nama_profil .
          ' ?';
          $encoded_pesan = urlencode($pesan); // Meng-encode pesan agar aman dalam URL
          $whatsapp_url = "https://wa.me/{$no_wa}?text={$encoded_pesan}"; // Membuat URL lengkap
          @endphp

          <a href="{{ $whatsapp_url }}"><i class="ti ti-notebook"></i> Kontak</a>
        </li>
        <!-- <div class="form-check form-switch mb-0">
          <label class="form-check-label text-white h6 mb-0" for="darkSwitch">Mode Gelap</label>
          <input class="form-check-input" id="darkSwitch" type="checkbox" role="switch">
        </div> -->

        <br><br>
        <li><a href="{{ asset('template/front') }}/#"> &copy; Copyright {{ $profil->nama_profil }}</a></li>




      </ul>
    </div>
  </div>
  <!-- PWA Install Alert -->
  <div class="toast pwa-install-alert shadow bg-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" data-bs-autohide="true">
    <div class="toast-body">
      <div class="content d-flex align-items-center mb-2"><img src="{{ asset('template/front') }}/img/icons/icon-72x72.png" alt="">
        <h6 class="mb-0">Tambahkan Ke Halaman Depan</h6>
        <button class="btn-close ms-auto" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
      </div><span class="mb-0 d-block">Click the<strong class="mx-1">Tambahkan Ke Halaman Depan</strong>button &amp; enjoy it like a regular app.</span>
    </div>
  </div>



  @yield('content')



  <!-- Internet Connection Status-->
  <div class="internet-connection-status" id="internetStatus"></div>
  <!-- Footer Nav-->
  <div class="footer-nav-area" id="footerNav">
    <div class="suha-footer-nav">
      <ul class="h-100 d-flex align-items-center justify-content-between ps-0 d-flex rtl-flex-d-row-r">
        <li><a href="/"><i class="ti ti-home"></i>Beranda</a></li>
        <li><a href="/produk"><i class="ti ti-package"></i>Produk</a></li>
        <li><a href="/toko"><i class="ti ti-building-store"></i>Toko</a></li>
        <li>
          <a href="/cart">
            <i class="ti ti-basket-bolt"></i>Keranjang
            @php
            $cart = Session::get('cart', []);
            $cartCount = count($cart);
            @endphp
            <span id="cartCount" style="color:red;"><b>({{ $cartCount }})</b></span>
          </a>
        </li>

        <li><a href="/blog"><i class="ti ti-news"></i>Blog</a></li>
        <li><a href="/"><i class="ti ti-login"></i>Login</a></li>
      </ul>
    </div>
  </div>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
  <!-- SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>





  <script>
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
      form.addEventListener('click', function(e) {
        e.preventDefault();
        const productId = form.getAttribute('data-product-id');
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route('cart.add') }}', {
              method: 'POST',
              body: formData,
            })
          .then(response => response.json())
          .then(data => {
            Swal.fire({
              title: 'Sukses!',
              text: data.message,
              icon: 'success',
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload();
              }
            });
          })
          .catch(error => {
            Swal.fire({
              title: 'Error!',
              text: 'Terjadi kesalahan, silakan coba lagi.',
              icon: 'error',
              confirmButtonText: 'OK'
            });
            console.error('Error:', error);
          });
      });
    });
  </script>



  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const lazyImages = document.querySelectorAll("img.lazy-img");

      const lazyLoad = (image) => {
        const src = image.getAttribute("data-original") || image.getAttribute("data-src");
        if (!src) return;

        const tempImage = new Image();
        tempImage.src = src;
        tempImage.crossOrigin = "anonymous"; // Hindari error CORS di beberapa server
        tempImage.onload = () => {
          image.src = src;
          image.classList.add("loaded"); // Tambahkan efek transisi saat gambar muncul
          optimizeImage(image, tempImage); // Optimalkan setelah lazy load selesai
        };
      };

      if ("IntersectionObserver" in window) {
        let observer = new IntersectionObserver((entries, observer) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              lazyLoad(entry.target);
              observer.unobserve(entry.target);
            }
          });
        });

        lazyImages.forEach(img => observer.observe(img));
      } else {
        // Fallback untuk browser lama
        lazyImages.forEach(img => lazyLoad(img));
      }
    });

    /** Optimasi Gambar */
    function optimizeImage(img, imgObj) {
      const canvas = document.createElement("canvas");
      const ctx = canvas.getContext("2d");
      const maksLebarGambar = 300;
      const maksTinggiGambar = 300;
      const kualitas = 0.7;

      let {
        width,
        height
      } = imgObj;
      const aspectRatio = width / height;

      if (width > maksLebarGambar || height > maksTinggiGambar) {
        if (aspectRatio > 1) {
          width = maksLebarGambar;
          height = width / aspectRatio;
        } else {
          height = maksTinggiGambar;
          width = height * aspectRatio;
        }
      }

      canvas.width = width;
      canvas.height = height;
      ctx.drawImage(imgObj, 0, 0, width, height);

      img.src = canvas.toDataURL("image/jpeg", kualitas);
    }
  </script>


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