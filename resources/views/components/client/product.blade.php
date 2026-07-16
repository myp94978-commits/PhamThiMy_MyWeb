@props(['product'])

<div class="card h-100 shadow-sm">
    {{-- Hình ảnh --}}
    @php
        $imageUrl = asset('images/default.png');

        if (!empty($product->image) && file_exists(public_path('storage/products/' . $product->image))) {
            $imageUrl = asset('storage/products/' . $product->image);
        } elseif (!empty($product->image) && Str::startsWith($product->image, ['http://', 'https://'])) {
            $imageUrl = $product->image;
        }
    @endphp

    <img src="{{ $imageUrl }}"
         class="card-img-top" alt="{{ $product->productname }}"
         style="height:150px;object-fit:cover;">

    <div class="card-body d-flex flex-column">
        {{-- Tên sản phẩm --}}
        <h6 class="card-title">
            {{ $product->productname }}
        </h6>

        {{-- Giá --}}
        @if ($product->pricediscount > 0)
            <div>
                <span class="text-decoration-line-through text-muted">
                    {{ number_format($product->price, 0, ',', '.') }} đ
                </span>
            </div>
            <h5 class="text-danger fw-bold">
                {{ number_format($product->pricediscount, 0, ',', '.') }} đ
            </h5>
        @else
            <h5 class="text-danger fw-bold">
                {{ number_format($product->price, 0, ',', '.') }} đ
            </h5>
        @endif

        {{-- Nút chức năng --}}
        <div class="mt-auto">
            <div class="row g-2">
                <div class="col-6">
                    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary w-100">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-success w-100 add-to-cart"
                            data-product-id="{{ $product->id }}"
                            data-product-name="{{ $product->productname }}"
                            data-product-price="{{ $product->pricediscount > 0 ? $product->pricediscount : $product->price }}"
                            data-product-image="{{ $imageUrl }}">
                        <i class="bi bi-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
