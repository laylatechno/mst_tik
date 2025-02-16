
    <!-- Top Products -->
    <div class="top-products-area py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Produk Pilihan</h6><a class="btn btn-sm btn-light" href="/product">Lihat Semua<i class="ms-1 ti ti-arrow-right"></i></a>
            </div>
            <div class="row g-2">
                @foreach ($data_products as $p)
                <!-- Product Card -->
                <div class="col-6 col-md-4">
                    <div class="card product-card">
                        <div class="card-body">
                            <!-- Badge-->
                            <!-- <span class="badge rounded-pill badge-warning">{{ $p->category->name ?? 'Tanpa Kategori' }}</span> -->
                            <!-- Wishlist Button-->
                            <!-- <a class="wishlist-btn" href="{{ asset('template/front') }}/#"><i class="ti ti-heart"> </i></a> -->
                            <!-- Thumbnail -->
                            <a class="product-thumbnail d-block" href="{{ route('product.product_detail', $p->slug) }}">
                                <img class="mb-2 lazy-img"
                                    src="https://placehold.co/300x200?text=Loading..."
                                    data-src="/upload/products/{{ $p->image }}"
                                    data-original="/upload/products/{{ $p->image }}"
                                    alt="{{ $p->name }}">

                            </a>

                            <!-- Offer Countdown Timer: Please use event time this format: YYYY/MM/DD hh:mm:ss -->
                            <!-- <ul class="offer-countdown-timer d-flex align-items-center shadow-sm" data-countdown="2024/12/31 23:59:59">
                                    <li><span class="days">0</span>d</li>
                                    <li><span class="hours">0</span>h</li>
                                    <li><span class="minutes">0</span>m</li>
                                    <li><span class="seconds">0</span>s</li>
                                </ul> -->
                            </a>
                            <a class="store-badge" href="{{ url('produk?category=' . $p->category->slug) }}">
                                {{ $p->category->name ?? 'Tanpa Kategori' }}
                            </a>

                            <a class="product-title" href="{{ route('product.product_detail', $p->slug) }}">
                                {{ $p->name }}
                            </a>


                            <!-- <p class="sale-price">$13<span>$42</span></p> -->

                            <p class="sale-price-new">
                                Rp {{ number_format($p->cost_price, 0, ',', '.') }}
                                @if($p->price_before_discount && $p->price_before_discount > 0)
                                <br> <span class="old-price">Rp {{ number_format($p->price_before_discount, 0, ',', '.') }}</span>
                                @endif
                            </p>

                            <a href="">
                                <p class="custom-badge">{{ $p->user->user }} </p>
                            </a>

                            <span class="product-note">
                                {{ $p->note }}
                            </span>
                            <br>




                            <!-- Rating -->
                            <!-- <div class="product-rating"><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i></div> -->
                            <!-- Add to Cart -->
                            <br>
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

