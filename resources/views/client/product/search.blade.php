@extends('client.layouts.app')

@section('title', 'Kết Quả Tìm Kiếm: ' . ($keyword ?? '') . ' - MyWeb')

@section('content')
<div class="container">
    {{-- Search Header --}}
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('product.search') }}" class="row g-2 align-items-center">
                        <div class="col-md-5">
                            <input type="text" class="form-control form-control-lg" name="q" 
                                   placeholder="Tìm kiếm sản phẩm..." value="{{ $keyword ?? request('q') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control form-control-lg" name="price_min" min="0"
                                   placeholder="Giá từ" value="{{ request('price_min') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control form-control-lg" name="price_max" min="0"
                                   placeholder="Giá đến" value="{{ request('price_max') }}">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-lg" name="sort">
                                <option value="">Sắp xếp</option>
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Tên A → Z</option>
                                <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Tên Z → A</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                            </select>
                        </div>
                        <div class="col-md-1 d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Results Header --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>
                Kết Quả Tìm Kiếm: 
                <strong>"{{ request('q') }}"</strong>
                <small class="text-muted">({{ $products->total() }} kết quả)</small>
            </h2>
            <hr>
        </div>
    </div>
    
    
    {{-- Products Grid --}}
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
                    @if($products->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">← Trước</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}">← Trước</a></li>
                    @endif
                    
                    @php $paginationElements = $products->elements(); @endphp
                    @if(count($paginationElements))
                        @foreach($paginationElements as $element)
                            @if(is_string($element))
                                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                            @endif
                            @if(is_array($element))
                                @foreach($element as $page => $url)
                                    @if($page == $products->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        {!! $products->links('pagination::bootstrap-5') !!}
                    @endif
                    
                    @if($products->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}">Sau →</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Sau →</span></li>
                    @endif
                </ul>
            </nav>
            <p class="text-center text-muted small mt-3">Trang {{ $products->currentPage() }} / {{ $products->lastPage() }} - Tổng {{ $products->total() }} sản phẩm</p>
        @endif
    @else
        <div class="alert alert-info mt-5">
            <i class="bi bi-info-circle"></i> 
            <strong>Không tìm thấy sản phẩm</strong> 
            <p>Hãy thử tìm kiếm với từ khóa khác hoặc duyệt danh mục sản phẩm của chúng tôi.</p>
            <a href="{{ route('product.index') }}" class="btn btn-primary mt-2">
                Xem Tất Cả Sản Phẩm
            </a>
        </div>
    @endif
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
