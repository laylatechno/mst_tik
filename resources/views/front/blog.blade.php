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

  <div class="pb-3 pt-3">
    <div class="container">
      <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
        <h6>Kategori</h6>
      </div>
      <!-- Collection Slide-->
      <div class="collection-slide owl-carousel">
        @foreach ($data_blog_categories as $p)
        <div class="card collection-card text-center p-3">
          <a class="d-block text-decoration-none" href="{{ url('blog?category=' . $p->slug) }}">
            <div class="collection-title">
              <span class="fw-bold">{{ $p->name }}</span>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </div>



  <div class="container">
    <div class="search-form rtl-flex-d-row-r">
      <form action="{{ route('blog') }}" method="GET">
        <input class="form-control" type="search" name="search" placeholder="Cari berita.." value="{{ request('search') }}">
        <button type="submit"><i class="ti ti-search"></i></button>
      </form>
      <div class="alternative-search-options">
        <div class="dropdown">
          <a class="btn btn-primary dropdown-toggle" id="altSearchOption" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ti ti-adjustments-horizontal"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="altSearchOption">
            <li><a class="dropdown-item" href="{{ route('blog', ['search' => request('search'), 'sort' => 'terlama']) }}"><i class="ti ti-check"></i> Terlama</a></li>
            <li><a class="dropdown-item" href="{{ route('blog', ['search' => request('search'), 'sort' => 'terbaru']) }}"><i class="ti ti-check"></i> Terbaru</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>


  <!-- Menampilkan Blog berdasarkan Kategori -->
  <div class="weekly-best-seller-area pt-3">
    <div class="container">
    
      <div class="row g-2">
        @forelse ($data_blogs as $p)
        <div class="col-12">
          <div class="card horizontal-product-card">
            <div class="d-flex align-items-center">
              <div class="product-thumbnail-side">
                <a class="product-thumbnail d-block" href="{{ route('blog.blog_detail', $p->slug) }}">
                  <img class="mb-2 lazy-img"
                    src="https://placehold.co/300x200?text=Loading..."
                    data-src="/upload/blogs/{{ $p->image }}"
                    alt="{{ $p->title }}">
                </a>
              </div>
              <div class="product-description py-2">
                <a class="product-title d-block" href="{{ route('blog.blog_detail', $p->slug) }}">{{ $p->title }}</a>
                <p>{{ $p->writer }}<span class="ms-1"> | {{ $p->posting_date }}</span></p>
                <p class="sale-price"><i class="ti ti-tag"></i>{{ $p->blog_category->name ?? 'Uncategorized' }}</p>
              </div>
            </div>
          </div>
        </div>
        @empty
        <p>No blog posts available in this category.</p>
        @endforelse
        <div class="shop-pagination pt-2">
           
            <div class="card">
              <div class="card-body py-3">
                {{-- Pagination untuk data_blog_categories --}}
                {{ $data_blogs->links('vendor.pagination.bootstrap-4') }}
              </div>
            </div>
         
        </div>

      </div>

    </div>
  </div>




  <!-- CTA Area -->
  <div class="container py-3">
    <div class="cta-text dir-rtl p-4 p-lg-5">
      <div class="row">
        <div class="col-9">
          <h5 class="text-white">Bisnis Anda Butuh Aplikasi/Website?</h5><a class="btn btn-primary" href=""><i class="ti ti-bell"></i> Hubungi Kami</a>
        </div>
      </div><img src="{{ asset('template/front') }}/img/website.png" alt="">
    </div>
  </div>



</div>

@endsection