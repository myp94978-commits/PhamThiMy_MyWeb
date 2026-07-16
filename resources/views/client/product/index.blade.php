@extends('client.layouts.app')

@section('title', 'Danh Sách Sản Phẩm - MyWeb')

@section('content')
<div class="container">
    <div class="row">
        {{-- Sidebar Filters --}}
        <div class="col-md-3 mb-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-funnel"></i> Bộ Lọc</h5>
                </div>
                
                <div class="card-body">
                    <form id="filterForm" action="{{ route('product.index') }}" method="GET">
                        {{-- Search --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tìm Kiếm</label>
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" placeholder="Tên sản phẩm...">
                        </div>
                        
                        {{-- Category Filter --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Danh Mục</label>
                            <div class="filter-group">
                                @foreach($categories ?? [] as $category)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="categories[]" 
                                               value="{{ $category->id }}" id="cat-{{ $category->id }}"
                                               {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cat-{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        {{-- Brand Filter --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Thương Hiệu</label>
                            <div class="filter-group">
                                @foreach($brands ?? [] as $brand)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="brands[]" 
                                               value="{{ $brand->id }}" id="brand-{{ $brand->id }}"
                                               {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="brand-{{ $brand->id }}">
                                            {{ $brand->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        {{-- Price Range --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Khoảng Giá</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" 
                                           name="price_min" placeholder="Từ" value="{{ request('price_min') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" 
                                           name="price_max" placeholder="Đến" value="{{ request('price_max') }}">
                                </div>
                            </div>
                        </div>
                        
                        {{-- Sort --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sắp Xếp</label>
                            <select class="form-select form-select-sm" name="sort">
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>
                                    Mới Nhất
                                </option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>
                                    Giá Tăng Dần
                                </option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>
                                    Giá Giảm Dần
                                </option>
                                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>
                                    Phổ Biến
                                </option>
                            </select>
                        </div>
                        
                        {{-- Buttons --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-funnel"></i> Lọc
                            </button>
                            <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise"></i> Đặt Lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        {{-- Products Grid --}}
        <div class="col-md-9">
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Danh Sách Sản Phẩm</h2>
                <span class="badge bg-secondary">{{ $products->total() ?? 0 }} sản phẩm</span>
            </div>
            
            {{-- Products --}}
            @if($products && count($products) > 0)
                <div class="row g-4 mb-4">
                    @foreach($products as $product)
                        <div class="col-md-6 col-lg-4">
                            <x-client.product :product="$product" />
                        </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                @if($products->hasPages())
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            @if($products->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">← Trước</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->previousPageUrl() }}">← Trước</a>
                                </li>
                            @endif
                            
                            {{-- Pagination Elements --}}
@php $paginationElements = $products->elements(); @endphp
                    @if(count($paginationElements))
                        @foreach($paginationElements as $element)
                            @if(is_string($element))
                                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                            @endif
                            @if(is_array($element))
                                @foreach($element as $page => $url)
                                    @if($page == $products->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        {!! $products->links('pagination::bootstrap-5') !!}
                    @endif
                            
                            {{-- Next Page Link --}}
                            @if($products->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->nextPageUrl() }}">Sau →</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Sau →</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                    <p class="text-center text-muted small mt-3">Trang {{ $products->currentPage() }} / {{ $products->lastPage() }} - Tổng {{ $products->total() }} sản phẩm</p>
                @endif
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Không tìm thấy sản phẩm phù hợp
                </div>
            @endif
        </div>
    </div>
</div>

<style>
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
    
    .sticky-top {
        z-index: 1000;
    }
</style>

@section('js')
<script>
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
</script>
@endsection

@endsection
