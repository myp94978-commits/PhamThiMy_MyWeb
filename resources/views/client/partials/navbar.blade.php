<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-2">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Mini Shop</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
                </li>

                {{-- Dropdown Danh mục --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarCategoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Danh mục
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarCategoryDropdown">
                        @foreach($categories as $item)
                            <li>
                                <a class="dropdown-item" href="{{ route('products.category', $item->slug) }}">
                                    {{ $item->catename }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                {{-- Dropdown Thương hiệu --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarBrandDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Thương hiệu
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarBrandDropdown">
                        @foreach($brands as $item)
                            <li>
                                <a class="dropdown-item" href="{{ route('product.brand', $item->slug) }}">
                                    {{ $item->brandname }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Liên hệ</a>
                </li>
            </ul>

            <form method="GET" action="{{ route('product.search') }}" class="d-flex align-items-center me-3" role="search">
                <input class="form-control form-control-sm me-2" type="search" placeholder="Tìm sản phẩm..."
                       aria-label="Search" name="q" value="{{ request('q') }}">
                <button class="btn btn-primary btn-sm" type="submit">Tìm</button>
            </form>

            <a class="btn btn-outline-secondary btn-sm d-flex align-items-center" href="{{ route('cart.show') }}">
                <i class="bi bi-cart3 me-2"></i>
                Giỏ hàng (
                <span class="badge bg-warning text-dark" id="cart-count">
                    {{ count(session('cart', [])) }}
                </span>
                )
            </a>
        </div>
    </div>
</nav>
