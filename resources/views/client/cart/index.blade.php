@extends('client.layouts.app')

@section('title', 'Giỏ Hàng - MyWeb')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="bi bi-cart3"></i> Giỏ Hàng Của Bạn</h2>
    
    <div id="cartContainer">
        <div class="row" id="emptyCart" style="display: none;">
            <div class="col-md-12">
                <div class="alert alert-info text-center py-5">
                    <h4><i class="bi bi-inbox"></i> Giỏ Hàng Trống</h4>
                    <p class="text-muted mb-3">Chưa có sản phẩm nào trong giỏ hàng của bạn</p>
                    <a href="{{ route('product.index') }}" class="btn btn-primary">
                        Tiếp Tục Mua Sắm
                    </a>
                </div>
            </div>
        </div>
        
        <div id="cartContent" style="display: none;">
            <div class="row">
                {{-- Cart Items --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sản Phẩm</th>
                                        <th>Giá</th>
                                        <th>Số Lượng</th>
                                        <th>Tổng</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="cartItems">
                                    {{-- Items will be rendered here by JS --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Tiếp Tục Mua Sắm
                        </a>
                    </div>
                </div>
                
                {{-- Summary --}}
                <div class="col-md-4">
                    <div class="card position-sticky" style="top: 20px;">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">Tóm Tắt Đơn Hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <strong id="subtotal">0₫</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí Vận Chuyển:</span>
                                <strong id="shipping">0₫</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Thuế:</span>
                                <strong id="tax">0₫</strong>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Tổng Cộng:</strong>
                                <h5 class="mb-0 text-primary" id="total">0₫</h5>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-lg">
                                    <i class="bi bi-credit-card"></i> Thanh Toán
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .quantity-input {
        width: 60px;
    }
    
    .btn-remove {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>

@section('js')
<script>
    function renderCart() {
        const cart = CartHelper.getCart();
        const cartItems = document.getElementById('cartItems');
        const emptyCart = document.getElementById('emptyCart');
        const cartContent = document.getElementById('cartContent');
        
        if (cart.length === 0) {
            emptyCart.style.display = 'block';
            cartContent.style.display = 'none';
            return;
        }
        
        emptyCart.style.display = 'none';
        cartContent.style.display = 'block';
        
        cartItems.innerHTML = '';
        let subtotal = 0;
        
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="d-flex gap-2">
                        <img src="${item.image}" alt="${item.name}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        <div>
                            <strong>${item.name}</strong>
                        </div>
                    </div>
                </td>
                <td>${formatPrice(item.price)}</td>
                <td>
                    <div class="input-group input-group-sm quantity-input">
                        <button class="btn btn-outline-secondary" onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                        <input type="text" class="form-control text-center" value="${item.quantity}" readonly>
                        <button class="btn btn-outline-secondary" onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                    </div>
                </td>
                <td>${formatPrice(itemTotal)}</td>
                <td>
                    <button class="btn btn-sm btn-danger btn-remove" onclick="removeItem(${item.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            cartItems.appendChild(row);
        });
        
        updateSummary(subtotal);
    }
    
    function updateQuantity(productId, quantity) {
        if (quantity <= 0) {
            CartHelper.removeFromCart(productId);
        } else {
            CartHelper.updateQuantity(productId, quantity);
        }
        CartHelper.updateUI();
        renderCart();
    }
    
    function removeItem(productId) {
        if (confirm('Bạn chắc chứ?')) {
            CartHelper.removeFromCart(productId);
            CartHelper.updateUI();
            renderCart();
            showToast('Xóa khỏi giỏ hàng thành công', 'success');
        }
    }
    
    function updateSummary(subtotal) {
        const shipping = subtotal > 0 ? 30000 : 0;
        const tax = Math.floor(subtotal * 0.1);
        const total = subtotal + shipping + tax;
        
        document.getElementById('subtotal').textContent = formatPrice(subtotal);
        document.getElementById('shipping').textContent = formatPrice(shipping);
        document.getElementById('tax').textContent = formatPrice(tax);
        document.getElementById('total').textContent = formatPrice(total);
    }
    
    const initCartPage = () => {
        renderCart();
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCartPage);
    } else {
        initCartPage();
    }
</script>
@endsection

@endsection
