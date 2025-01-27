@extends('front.layouts.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">

<style>
  .testimonial-item {
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease;
    cursor: pointer;
  }

  .testimonial-item:hover {
    transform: scale(1.05);
  }

  .testimonial-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .testimonial-item:hover .testimonial-overlay {
    opacity: 1;
  }

  .testimonial-img {
    width: 100%;
    height: 300px;
    object-fit: cover;
  }

  .modal-img {
    width: 100%;
    max-height: 500px;
    object-fit: contain;
  }
</style>


@section('content')
<!-- breadcrumb-area start -->
<div class="breadcrumb-area section-ptb" style="background-image: url('https://images.unsplash.com/photo-1599666805921-c468c04cbfc4?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="breadcrumb-title">Testimoni</h2>
        <!-- breadcrumb-list start -->
        <ul class="breadcrumb-list">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Testimoni</li>
        </ul>
        <!-- breadcrumb-list end -->
      </div>
    </div>
  </div>
</div>
<!-- breadcrumb-area end -->


<!-- main-content-wrap start -->
<div class="main-content-wrap">
  <!-- About Us Area -->
  <div class="about-us-area section-ptb">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <div class="about-us-contents">
            <h3>Selamat Datang di <span>{{ $profil->nama_profil }}</span></h3>
            <p>{{ $profil->nama_profil }} merupakan platform pembawa ungkapan kasih dan silaturahmi #1 di Indonesia. {{ $profil->nama_profil }} berpengalamanan selama lebih dari 10 tahun dalam membantu pelanggan tercinta, baik perusahaan maupun individu untuk berkirim karangan bunga, parcel/hampers dan gift ke 200 kota dan kabupaten di Indonesia </p>

            <a href="">
              <button class="register-btn btn" type="submit" style="padding: 10px 20px; background-color:rgb(248, 91, 0); color: white; border: none; border-radius: 5px; cursor: pointer;">
                <span><i class="ion-social-whatsapp"></i> Hubungi Via WhatsApp</span>
              </button>
            </a>

          </div>
        </div>
        <div class="col-lg-4 ">
          <div class="about-us-image text-right">
            <img src="{{ asset('/upload/profil/' . $profil->logo) }}" alt="" style="width:80%;">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--// About Us Area -->


  <section class="container py-5">
  <h4 class="text-center mb-4">Testimonial Pelanggan</h4>

  <div class="row g-4">
    @foreach ($data_testimonial as $p)
      <!-- Testimonial -->
      <div class="col-md-6 col-lg-3">
        <div class="testimonial-item rounded shadow" data-bs-toggle="modal" data-bs-target="#modal{{ $p->id }}">
          <img src="/upload/testimonial/{{ $p->image }}" alt="Person {{ $p->id }}" class="testimonial-img rounded">
          <div class="testimonial-overlay text-white p-3 text-center">
            <!-- <h5 class="mb-2">{{ $p->name }}</h5> -->
            <!-- <p class="mb-2">{{ $p->position }}</p> -->
            <!-- <p class="fst-italic mb-0">{{ $p->testimonial }}</p> -->
          </div>
        </div>
      </div>

      <!-- Modal for each testimonial -->
      <div class="modal fade" id="modal{{ $p->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{ $p->name }} - {{ $p->position }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
              <img src="/upload/testimonial/{{ $p->image }}" alt="{{ $p->name }}" class="modal-img mb-3">
              <p class="lead">{{ $p->testimonial }}</p>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>


</div>
<!-- main-content-wrap end -->




@endsection