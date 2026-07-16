@extends('client.layouts.app')

@section('title', 'Trang Chủ - MyWeb E-Commerce')

@section('content')
<div class="container py-5">
    {{-- Khu vực 1: Sản Phẩm Mới Nhất --}}
    <section class="latest-products-section mb-5">
        <div class="d-flex align-items-center mb-4">
            <h2 class="mb-0">
                <i class="bi bi-lightning-fill text-warning"></i> Sản Phẩm Mới Nhất
            </h2>
        </div>
        
        <div class="row g-4">
            @forelse($newProducts ?? [] as $product)
                <div class="col-md-6 col-lg-3">
                    <x-client.product :product="$product" badge="Mới" />
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> Không có sản phẩm mới
                    </div>
                </div>
            @endforelse
        </div>
    </section>
    
    {{-- Khu vực 3: Sản Phẩm Giảm Giá / Thanh Lý --}}
    <section class="discounted-products-section mb-5">
        <div class="d-flex align-items-center mb-4">
            <h2 class="mb-0">
                <i class="bi bi-percent text-success"></i> Sản Phẩm Giảm Giá
            </h2>
        </div>
        
        <div class="row g-4">
            @forelse($saleProducts ?? [] as $product)
                <div class="col-md-6 col-lg-3">
                    <x-client.product :product="$product" badge="Sale" />
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> Không có sản phẩm giảm giá
                    </div>
                </div>
            @endforelse
        </div>
    </section>

@endsection

@section('js')
<script>
    // Xử lý nút "Thêm vào giỏ hàng"
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const productPrice = parseFloat(this.dataset.productPrice);
            const productImage = this.dataset.productImage;

            // Thêm sản phẩm vào giỏ hàng
            CartHelper.addToCart({
                id: productId,
                name: productName,
                price: productPrice,
                quantity: 1,
                image: productImage
            });

            CartHelper.updateUI();
            showToast(`Đã thêm "${productName}" vào giỏ hàng`, 'success', 2000);
        });
    });
</script>
@endsection
