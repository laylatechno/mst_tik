  <!-- Weekly Best Sellers-->
  <div class="weekly-best-seller-area pt-2">
      <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
              <h6>Informasi Terbaru</h6><a class="btn btn-sm btn-light" href="{{ asset('template/front') }}/shop-list.html">
                  Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
          </div>
          <div class="row g-2">
              @foreach ($data_blogs as $p)
              <div class="col-12">
                  <div class="card horizontal-product-card">
                      <div class="d-flex align-items-center">
                          <div class="product-thumbnail-side">
                              <a class="product-thumbnail d-block" href="{{ route('product.product_detail', $p->slug) }}">
                                  <img
                                      class="mb-2 lazy-img"
                                      src="https://placehold.co/300x200?text=Loading..."
                                      data-src="/upload/blogs/{{ $p->image }}"
                                      alt="{{ $p->titile }}">
                              </a>
                          </div>
                          <div class="product-description py-2">
                              <!-- Product Title --><a class="product-title d-block" href="/">{{ $p->title }}</a>


                              <p>
                              {{ $p->writer }}<span class="ms-1"> | {{ $p->posting_date }} </span>
                              </p>
                              <p class="sale-price"><i class="ti ti-tag"></i>Olahraga</p>
                          </div>
                      </div>
                  </div>
              </div>
              @endforeach

          </div>
      </div>
  </div>