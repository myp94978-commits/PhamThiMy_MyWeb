<header class="site-topbar bg-dark text-white py-2">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div class="topbar-left small text-white-75">
                <span class="me-4">
                    <i class="bi bi-telephone-fill me-1"></i>
                    Hotline: 0909 999 999
                </span>
                <span>
                    <i class="bi bi-envelope-fill me-1"></i>
                    Email: support@minishop.com
                </span>
            </div>
            <div class="topbar-right small text-white-75">
                @guest
                    <a href="{{ route('login') }}" class="text-white text-decoration-none me-3">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="text-white text-decoration-none me-3">Đăng ký</a>
                @else
                    <span class="me-3">Xin chào {{ auth()->user()->fullname }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link text-white p-0 m-0 align-baseline text-decoration-none">Đăng xuất</button>
                    </form>
                @endguest
                <a href="{{ route('contact') }}" class="text-white text-decoration-none">Liên hệ</a>
            </div>
        </div>
    </div>
</header>
