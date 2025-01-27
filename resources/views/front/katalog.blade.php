@extends('front.layouts.app')


@section('content')
<!-- breadcrumb-area start -->
<div class="breadcrumb-area section-ptb" style="background-image: url('https://images.unsplash.com/photo-1599666805921-c468c04cbfc4?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="breadcrumb-title">Katalog</h2>
        <!-- breadcrumb-list start -->
        <ul class="breadcrumb-list">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Katalog</li>
        </ul>
        <!-- breadcrumb-list end -->
      </div>
    </div>
  </div>
</div>
<!-- breadcrumb-area end -->


<!-- main-content-wrap start -->
<div class="main-content-wrap">
 
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
            
              <a href="{{ route('katalog.katalog_detail', $p->slug) }}" class="add-to-cart" style="text-align: center;">  Detail</a>
 
          
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


</div>
<!-- main-content-wrap end -->


@endsection