@extends('client.layouts.app')

@section('title', ($products->first()?->brandname ?? 'Thương hiệu') . ' - MyWeb')

@section('content')
<div class="container">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Sản Phẩm</a></li>
            <li class="breadcrumb-item active">{{ $products->first()?->brandname ?? 'Không xác định' }}</li>
        </ol>
    </nav>
    
    <h3 class="mb-4">
        Thương hiệu: {{ $products->first()?->brandname ?? 'Không xác định' }}
    </h3>
    
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
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Không tìm thấy sản phẩm từ thương hiệu này
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
