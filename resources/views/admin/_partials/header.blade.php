<div class="admin-header">
    <div class="header-title">
        <span class="navbar-brand mb-0 h5">Admin Panel</span>
    </div>
    <div class="user-actions">
        @auth
            <span>Xin chào {{ Auth::user()->fullname }}</span>
            <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-link p-0 text-decoration-none">
                    Đăng xuất
                </button>
            </form>
        @else
            <a href="{{ route('admin.login') }}" class="text-decoration-none">Đăng nhập</a>
        @endauth
    </div>
</div>
