<div class="top-products-area py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Kategori {{ $third_category->name }}</h6><a class="btn btn-sm btn-light" href="/l">Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
            </div>
            <div class="row g-2">
                @foreach ($product_third_category as $p)
                <!-- Product Card -->
                <div class="col-6 col-md-4">
                    <div class="card product-card">
                        <div class="card-body">

                            <a class="product-thumbnail d-block" href="{{ route('product.product_detail', $p->slug) }}">
                                <img class="mb-2 lazy-img"
                                    src="https://placehold.co/300x200?text=Loading..."
                                    data-src="/upload/products/{{ $p->image }}"
                                    data-original="/upload/products/{{ $p->image }}"
                                    alt="{{ $p->name }}">

                            </a>
                            <a class="product-title" href="/">{{ $p->name }}</a>

                            <p class="sale-price-new">
                                Rp {{ number_format($p->cost_price, 0, ',', '.') }}
                                @if($p->price_before_discount && $p->price_before_discount > 0)
                                <br> <span class="old-price">Rp {{ number_format($p->price_before_discount, 0, ',', '.') }}</span>
                                @endif
                            </p>

                            <p class="custom-badge">
                                {{ $p->category->name ?? 'Tanpa Kategori' }}
                            </p>

                            <span class="product-note">
                                {{ $p->note }}
                            </span>
                            <br><br>
                            <form class="add-to-cart-form" data-product-id="{{ $p->id }}">
                                @csrf
                                <button class="btn btn-primary btn-sm" type="button"><i class="ti ti-shopping-cart"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </div>
