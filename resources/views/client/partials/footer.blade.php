<footer class="footer-section bg-dark text-light pt-5 pb-4">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <h5 class="text-white mb-3">Mini Shop</h5>
                <p class="text-muted mb-0">
                    Mini Shop chuyên cung cấp các sản phẩm công nghệ, phụ kiện máy tính và thiết bị điện tử với chất lượng và giá cả hợp lý.
                </p>
            </div>
            <div class="col-md-4">
                <h5 class="text-white mb-3">Liên kết nhanh</h5>
                <ul class="list-unstyled footer-link-list mb-0">
                    <li><a href="{{ route('home') }}" class="text-muted text-decoration-none">Trang chủ</a></li>
                    <li><a href="{{ route('product.index') }}" class="text-muted text-decoration-none">Sản phẩm</a></li>
                    <li><a href="{{ route('cart.index') }}" class="text-muted text-decoration-none">Giỏ hàng</a></li>
                    <li><a href="{{ route('contact') }}" class="text-muted text-decoration-none">Liên hệ</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="text-white mb-3">Liên hệ</h5>
                <p class="text-muted mb-2">
                    <i class="bi bi-geo-alt-fill me-2"></i>123 Nguyễn Văn XXX, TP. Hồ Chí Minh
                </p>
                <p class="text-muted mb-2">
                    <i class="bi bi-telephone-fill me-2"></i>0909 999 999
                </p>
                <p class="text-muted mb-0">
                    <i class="bi bi-envelope-fill me-2"></i>support@minishop.com
                </p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <p class="text-muted small mb-0">© {{ date('Y') }} Mini Shop. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>
