@extends('front.layouts.app')


@section('content')
<!-- breadcrumb-area start -->
<div class="breadcrumb-area section-ptb" style="background-image: url('https://images.unsplash.com/photo-1599666805921-c468c04cbfc4?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="breadcrumb-title">Detail Katalog</h2>
        <!-- breadcrumb-list start -->
        <ul class="breadcrumb-list">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Detail Katalog</li>
        </ul>
        <!-- breadcrumb-list end -->
      </div>
    </div>
  </div>
</div>
<!-- breadcrumb-area end -->



<!-- main-content-wrap start -->
<div class="main-content-wrap section-ptb product-details-page">
  <div class="container">
    <div class="row">
      <div class="col-xl-5 col-lg-6 col-md-6">
        <div class="product-details-images">
          <div class="product_details_container">

            <!-- product_big_images start -->

            <div role="tabpanel">
              <a href="/upload/products/{{ $produk->image }}" class="img-poppu">
                <img src="/upload/products/{{ $produk->image }}" alt="#">
              </a>
            </div>


            <!-- product_big_images end -->


          </div>
        </div>
      </div>
      <div class="col-xl-7 col-lg-6 col-md-6">
        <!-- product_details_info start -->
        <div class="product_details_info">
          <h2>{{ $produk->name }}</h2>
          <p>{!! $produk->description !!}</p>
          <ul class="pro_dtl_prize">
            <li>Rp. {{ number_format($produk->cost_price, 0, ',', '.') }}</li>
          </ul>
          <hr>
          <div class="pro_dtl_color">
            <h2 class="title_2">Isi Data Pengiriman</h2>
          </div>

          <form id="orderForm">
            <input type="text" class="form-control mb-3" name="nama_pemesan" id="nama_pemesan" placeholder="Masukkan Nama Pemesan" required>
            <input type="datetime-local" class="form-control mb-3" name="waktu" id="waktu" required>
            <textarea name="alamat" id="alamat" class="form-control mb-3" placeholder="Masukkan Alamat Pengiriman" rows="2" cols="50" required></textarea>
            <textarea name="ucapan" id="ucapan" class="form-control mb-3" placeholder="Masukkan Ucapan" rows="3" cols="50"></textarea>
            <button type="button" id="pesanSekarangBtn" class="register-btn btn" style="padding: 10px 20px; background-color:rgb(27, 221, 75); color: white; border: none; border-radius: 5px; cursor: pointer;">
              <span><i class="ion-social-whatsapp"></i> Pesan Sekarang</span>
            </button>
          </form>

          <script>
            document.getElementById('pesanSekarangBtn').addEventListener('click', function() {
              // Ambil data dari form
              const namaPemesan = document.getElementById('nama_pemesan').value;
              const waktu = document.getElementById('waktu').value;
              const alamat = document.getElementById('alamat').value;
              const ucapan = document.getElementById('ucapan').value || '-';
              const produkNama = "{{ $produk->name }}";
              const produkHarga = "Rp. {{ number_format($produk->cost_price, 0, ',', '.') }}";
              const nomorWA = "{{ $profil->no_wa }}";

              // Format pesan WhatsApp
              const pesan = `Halo, saya ingin memesan produk berikut:\n\n` +
                `*Nama Produk:* ${produkNama}\n` +
                `*Harga:* ${produkHarga}\n\n` +
                `*Nama Pemesan:* ${namaPemesan}\n` +
                `*Waktu Pengiriman:* ${waktu}\n` +
                `*Alamat Pengiriman:* ${alamat}\n` +
                `*Ucapan:* ${ucapan}`;

              // Encode pesan agar sesuai dengan URL
              const encodedPesan = encodeURIComponent(pesan);

              // Redirect ke WhatsApp
              const whatsappUrl = `https://wa.me/${nomorWA}?text=${encodedPesan}`;
              window.open(whatsappUrl, '_blank');
            });
          </script>


          <div class="pro_social_share d-flex">
            <span>Note: setiap produk yang kosong akan diganti dengan yang sejenis/senilai sama</span>
          </div>
        </div>
        <!-- product_details_info end -->
      </div>

      <hr>
    </div>


    <!-- Start Product Area -->
    <div class="porduct-area section-pb" style="margin-top: 20px;">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">

            <div class="section-title">
              <h2><span>Produk</span> Lain</h2>
              <p>Menjadikan pilihanmu lebih beragam dan variatif sesuai dengan kebutuhan anda</p>
            </div>
          </div>
        </div>

        <div class="row product-two-row-4">


          @foreach ($produk_lain as $p)
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

  </div>
</div>
<!-- main-content-wrap end -->



@endsection