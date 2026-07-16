@extends('client.layouts.app')

@section('title', 'Thanh Toán - MyWeb')

@section('content')
<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-credit-card"></i> Thanh Toán</h2>
    
    <div class="row">
        {{-- Checkout Form --}}
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">1. Thông Tin Giao Hàng</h5>
                </div>
                <div class="card-body">
                    <form id="checkoutForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Họ Tên *</label>
                                <input type="text" class="form-control" name="full_name" required 
                                       @auth value="{{ auth()->user()->name }}" @endauth>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" required
                                       @auth value="{{ auth()->user()->email }}" @endauth>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Số Điện Thoại *</label>
                            <input type="tel" class="form-control" name="phone" required placeholder="Ví dụ: 0123456789">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Địa Chỉ *</label>
                            <input type="text" class="form-control" name="address" required 
                                   placeholder="Số nhà, tên đường">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Thành Phố/Tỉnh *</label>
                                <input type="text" class="form-control" name="city" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mã Bưu Chính</label>
                                <input type="text" class="form-control" name="postal_code">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Ghi Chú Đơn Hàng</label>
                            <textarea class="form-control" name="notes" rows="3" placeholder="Ghi chú thêm (tùy chọn)"></textarea>
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- Payment Method --}}
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">2. Phương Thức Thanh Toán</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" 
                               id="cod" value="cod" checked>
                        <label class="form-check-label" for="cod">
                            <strong>Thanh Toán Khi Nhận Hàng (COD)</strong>
                            <br>
                            <small class="text-muted">Bạn sẽ thanh toán khi nhận được sản phẩm</small>
                        </label>
                    </div>
                    
                    <hr>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" 
                               id="bank" value="bank">
                        <label class="form-check-label" for="bank">
                            <strong>Chuyển Khoản Ngân Hàng</strong>
                            <br>
                            <small class="text-muted">Chuyển tiền trước, chúng tôi sẽ xác nhận và gửi hàng</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Order Summary --}}
        <div class="col-md-4">
            <div class="card position-sticky" style="top: 20px;">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Tóm Tắt Đơn Hàng</h5>
                </div>
                <div class="card-body">
                    <div id="summaryItems" style="max-height: 300px; overflow-y: auto;">
                        {{-- Items will be rendered here by JS --}}
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <strong id="summarySubtotal">0₫</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí Vận Chuyển:</span>
                        <strong id="summaryShipping">0₫</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Thuế:</span>
                        <strong id="summaryTax">0₫</strong>
                    </div>
                    
                    <div class="alert alert-info">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> 
                            Vui lòng kiểm tra kỹ thông tin trước khi thanh toán
                        </small>
                    </div>
                    
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>Tổng Cộng:</strong>
                            <h5 class="mb-0 text-primary" id="summaryTotal">0₫</h5>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary w-100 btn-lg" id="submitBtn">
                        <i class="bi bi-check-circle"></i> Đặt Hàng
                    </button>
                    
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="bi bi-arrow-left"></i> Quay Lại Giỏ Hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    function renderSummary() {
        const cart = CartHelper.getCart();
        const summaryItems = document.getElementById('summaryItems');
        
        let subtotal = 0;
        summaryItems.innerHTML = '';
        
        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            
            const itemDiv = document.createElement('div');
            itemDiv.className = 'mb-3 pb-3 border-bottom';
            itemDiv.innerHTML = `
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <strong>${item.name}</strong>
                        <br>
                        <small class="text-muted">x${item.quantity}</small>
                    </div>
                    <strong>${formatPrice(itemTotal)}</strong>
                </div>
            `;
            summaryItems.appendChild(itemDiv);
        });
        
        const shipping = subtotal > 0 ? 30000 : 0;
        const tax = Math.floor(subtotal * 0.1);
        const total = subtotal + shipping + tax;
        
        document.getElementById('summarySubtotal').textContent = formatPrice(subtotal);
        document.getElementById('summaryShipping').textContent = formatPrice(shipping);
        document.getElementById('summaryTax').textContent = formatPrice(tax);
        document.getElementById('summaryTotal').textContent = formatPrice(total);
    }
    
    const initCheckoutPage = () => {
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = document.getElementById('checkoutForm');
            
            // Validate form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            const formData = new FormData(form);
            const data = {
                full_name: formData.get('full_name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                address: formData.get('address'),
                city: formData.get('city'),
                postal_code: formData.get('postal_code'),
                notes: formData.get('notes'),
                payment_method: document.querySelector('input[name="payment_method"]:checked').value,
                items: CartHelper.getCart(),
                total: CartHelper.getTotal()
            };
            
            console.log('Order Data:', data);
            
            // Submit order (this should be connected to your backend API)
            post('/api/orders', data)
                .then(response => {
                    showToast('Đặt hàng thành công!', 'success');
                    CartHelper.clearCart();
                    CartHelper.updateUI();
                    
                    // Redirect to order confirmation or home page
                    setTimeout(() => {
                        window.location.href = '{{ route("home") }}';
                    }, 2000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Có lỗi xảy ra. Vui lòng thử lại', 'danger');
                });
        });
        
        renderSummary();
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCheckoutPage);
    } else {
        initCheckoutPage();
    }
</script>
@endsection

@endsection
