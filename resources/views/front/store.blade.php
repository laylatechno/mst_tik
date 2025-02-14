@extends('front.layouts.app')


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
      <div class="suha-navbar-toggler ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas" aria-controls="suhaOffcanvas">
        <div><span></span><span></span><span></span></div>
      </div>
    </div>
  </div>


  <div class="container">
    <div class="search-form pt-3 rtl-flex-d-row-r">
      <form action="{{ route('store') }}" method="GET">
        <input class="form-control" type="search" name="search" placeholder="Cari toko.." value="{{ request('search') }}">
        <button type="submit"><i class="ti ti-search"></i></button>
      </form>
      <div class="alternative-search-options">
        <div class="dropdown">
          <a class="btn btn-primary dropdown-toggle" id="altSearchOption" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ti ti-adjustments-horizontal"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="altSearchOption">
            <li><a class="dropdown-item" href="{{ route('store', ['search' => request('search'), 'sort' => 'terlama']) }}"><i class="ti ti-check"></i> Terlama</a></li>
            <li><a class="dropdown-item" href="{{ route('store', ['search' => request('search'), 'sort' => 'terbaru']) }}"><i class="ti ti-check"></i> Terbaru</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>




  <div class="container py-3">
    <div class="row gy-3">

      @foreach ($data_stores as $p)
      <div class="col-12">
        <!-- Single Vendor -->
        <div class="single-vendor-wrap bg-img p-4 bg-overlay" style="background-image: url('/upload/users/{{ $p->banner }}')">
          <h6 class="vendor-title text-white">
            <a href="{{ route('store.store_detail', $p->user) }}" class="text-white">
              {{ $p->name }}
            </a>
          </h6>
          <div class="vendor-info">
            <p class="mb-1 text-white"><i class="ti ti-briefcase me-1"></i>{{ $p->about }}</p>
            <p class="mb-1 text-white"><i class="ti ti-map-pin me-1"></i>{{ $p->address }}</p>
            <div class="ratings lh-1">
              <a href="https://wa.me/{{ $p->wa_number }}" target="_blank">
                <span style="color: yellow;">{{ $p->wa_number }}</span>
              </a>
            </div>
          </div>
          <a class="btn btn-primary btn-sm mt-3" href="{{ route('store.store_detail', $p->user) }}">
            Kunjungi Toko <i class="ti ti-arrow-right ms-1"></i>
          </a>
          <!-- Vendor Profile-->
          <div class="vendor-profile shadow">
            <figure class="m-0"><img src="/upload/users/{{ $p->image }}" alt=""></figure>
          </div>
        </div>
      </div>
      @endforeach





    </div>
  </div>




</div>

@endsection