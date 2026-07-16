@extends('client.layouts.app')

@section('title', $product->name . ' - MyWeb')

@section('content')
<div class="container">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Sản Phẩm</a></li>
            @if($product->category)
                <li class="breadcrumb-item">
                    <a href="{{ route('products.category', $product->category->slug) }}">
                        {{ $product->category->name }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>
    
    {{-- Product Details --}}
    <div class="row mb-5">
        {{-- Gallery --}}
        <div class="col-md-5 mb-4">
            <div class="product-gallery">
                {{-- Main Image --}}
                <div class="main-image mb-3">
                    @php
                        $mainImagePath = $product->primary_image ?? null;
                        $mainImageUrl = null;

                        if (!empty($mainImagePath)) {
                            if (Str::startsWith($mainImagePath, ['http://', 'https://'])) {
                                $mainImageUrl = $mainImagePath;
                            } elseif (file_exists(public_path('images/' . $mainImagePath))) {
                                $mainImageUrl = asset('images/' . $mainImagePath);
                            } elseif (file_exists(storage_path('app/public/' . $mainImagePath))) {
                                $mainImageUrl = asset('storage/' . $mainImagePath);
                            } else {
                                $mainImageUrl = asset('images/default.png');
                            }
                        } else {
                            $mainImageUrl = asset('images/default.png');
                        }
                    @endphp

                    <img src="{{ $mainImageUrl }}" 
                         class="img-fluid rounded" id="mainImage" alt="{{ $product->name }}">
                </div>
                
                {{-- Thumbnails --}}
                @if($product->images->count() > 1)
                    <div class="thumbnails d-flex gap-2">
                        @foreach($product->images as $image)
                            @php
                                $thumbPath = $image->image_path ?? null;
                                $thumbUrl = null;

                                if (!empty($thumbPath)) {
                                    if (Str::startsWith($thumbPath, ['http://', 'https://'])) {
                                        $thumbUrl = $thumbPath;
                                    } elseif (file_exists(public_path('images/' . $thumbPath))) {
                                        $thumbUrl = asset('images/' . $thumbPath);
                                    } elseif (file_exists(storage_path('app/public/' . $thumbPath))) {
                                        $thumbUrl = asset('storage/' . $thumbPath);
                                    } else {
                                        $thumbUrl = asset('images/default.png');
                                    }
                                } else {
                                    $thumbUrl = asset('images/default.png');
                                }
                            @endphp

                            <img src="{{ $thumbUrl }}" 
                                 class="img-thumbnail rounded cursor-pointer" 
                                 style="width: 80px; height: 80px; object-fit: cover;"
                                 onclick="document.getElementById('mainImage').src = this.src"
                                 alt="Thumbnail">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        {{-- Product Info --}}
        <div class="col-md-7">
            {{-- Title & Category --}}
            <h1 class="mb-2">{{ $product->name }}</h1>
            <p class="text-muted mb-3">
                <span class="badge bg-secondary">{{ $product->category?->name }}</span>
                <span class="badge bg-info">{{ $product->brand?->name }}</span>
            </p>
            
            {{-- Rating --}}
            <div class="mb-3">
                <small>
                    @for($i = 0; $i < 5; $i++)
                        @if($i < floor($product->rating ?? 0))
                            <i class="bi bi-star-fill text-warning"></i>
                        @else
                            <i class="bi bi-star text-warning"></i>
                        @endif
                    @endfor
                    ({{ $product->rating ?? 0 }}/5 - 120 đánh giá)
                </small>
            </div>
            
            {{-- Price --}}
            <h3 class="text-primary fw-bold mb-3">
                {{ number_format($product->price, 0, ',', '.') }}₫
            </h3>
            
            {{-- Description --}}
            <p class="text-muted mb-4">
                {{ $product->description }}
            </p>
            
            {{-- Quantity & Add to Cart --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Số Lượng:</label>
                            <div class="input-group" style="max-width: 150px;">
                                <button class="btn btn-outline-secondary" type="button" id="decreaseQty">-</button>
                                <input type="number" class="form-control text-center" id="quantity" value="1" min="1">
                                <button class="btn btn-outline-secondary" type="button" id="increaseQty">+</button>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <small class="text-muted d-block">
                                Tồn Kho: <strong id="stock">{{ $product->quantity ?? 'N/A' }}</strong>
                            </small>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg" id="addToCartBtn">
                            <i class="bi bi-cart-plus"></i> Thêm Vào Giỏ Hàng
                        </button>
                        <button class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-heart"></i> Yêu Thích
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Additional Info --}}
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Thông Tin Bổ Sung</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}
                        </li>
                        <li class="mb-2">
                            <strong>Danh Mục:</strong> {{ $product->category?->name ?? 'N/A' }}
                        </li>
                        <li class="mb-2">
                            <strong>Thương Hiệu:</strong> {{ $product->brand?->name ?? 'N/A' }}
                        </li>
                        <li class="mb-2">
                            <strong>Ngày Tạo:</strong> {{ optional($product->created_at)->format('d/m/Y') ?? 'N/A' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Related Products --}}
    <section class="similar-products mb-5">
        <h3 class="mb-4">Sản Phẩm Cùng Loại</h3>
        
        <div class="row g-4">
            @forelse($relatedProducts ?? [] as $item)
                <div class="col-md-6 col-lg-3">
                    <x-client.product :product="$item" />
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Không có sản phẩm tương tự</div>
                </div>
            @endforelse
        </div>
    </section>
</div>

<style>
    .thumbnails img {
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.3s;
    }
    
    .thumbnails img:hover {
        opacity: 1;
    }
    
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    
    .product-image {
        height: 250px;
        object-fit: cover;
    }
</style>

@section('js')
<script>
    const quantity = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decreaseQty');
    const increaseBtn = document.getElementById('increaseQty');
    const addToCartBtn = document.getElementById('addToCartBtn');
    
    // Quantity controls
    decreaseBtn.addEventListener('click', () => {
        if (parseInt(quantity.value) > 1) {
            quantity.value = parseInt(quantity.value) - 1;
        }
    });
    
    increaseBtn.addEventListener('click', () => {
        quantity.value = parseInt(quantity.value) + 1;
    });
    
    const initProductShowPage = () => {
        // Add to cart
        addToCartBtn.addEventListener('click', () => {
            const product = {
                id: {{ $product->id }},
                name: '{{ $product->name }}',
                price: {{ $product->price }},
                quantity: parseInt(quantity.value),
                image: document.getElementById('mainImage').src
            };
            
            CartHelper.addToCart(product);
            CartHelper.updateUI();
            showToast('Đã thêm vào giỏ hàng', 'success');
        });
        
        // Add to cart from similar products
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                const product = {
                    id: this.dataset.productId,
                    name: this.dataset.productName,
                    price: parseFloat(this.dataset.productPrice),
                    quantity: 1,
                    image: this.closest('.card').querySelector('.product-image').src
                };
                
                CartHelper.addToCart(product);
                CartHelper.updateUI();
                showToast('Đã thêm vào giỏ hàng', 'success');
            });
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProductShowPage);
    } else {
        initProductShowPage();
    }
</script>
@endsection

@endsection
