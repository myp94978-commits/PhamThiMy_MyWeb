@extends('client.layouts.app')

@section('title', 'Liên Hệ - MyWeb')

@section('content')
<section class="contact-page py-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-5">
                <div class="p-4 rounded-4" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1);">
                    <h2 class="mb-3 text-white">Liên hệ với MyWeb</h2>
                    <p class="text-muted mb-4">Mọi thắc mắc về sản phẩm, đơn hàng hoặc chính sách đều được giải đáp nhanh chóng.</p>
                    <ul class="list-unstyled text-light">
                        <li class="mb-3"><i class="bi bi-telephone-fill me-2"></i>+84 123 456 789</li>
                        <li class="mb-3"><i class="bi bi-envelope-fill me-2"></i>support@myweb.com</li>
                        <li class="mb-3"><i class="bi bi-geo-alt-fill me-2"></i>Hà Nội, Việt Nam</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-3">Gửi phản hồi</h3>
                        <p class="text-muted mb-4">Bạn có thể gửi thông tin ở đây, chúng tôi sẽ phản hồi sớm nhất có thể.</p>
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" placeholder="Nhập họ và tên">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Nhập email của bạn">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nội dung</label>
                                <textarea class="form-control" rows="5" placeholder="Nhập nội dung liên hệ"></textarea>
                            </div>
                            <button type="button" class="btn btn-primary">Gửi liên hệ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
