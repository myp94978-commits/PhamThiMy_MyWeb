<div class="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="brand">
        <i class="bi bi-speedometer2"></i>
        <span>Admin</span>
    </a>

    <ul class="nav-list">

        <li>
            <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
        </li>

        <li>
            <a class="{{ request()->routeIs('admin.change-password') ? 'active' : '' }}"
               href="{{ route('admin.change-password') }}">
                <i class="bi bi-key-fill"></i> Đổi mật khẩu
            </a>
        </li>

        <li>
            <a class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
               href="{{ route('admin.categories.index') }}">
                <i class="bi bi-list-ul"></i> Danh sách loại sản phẩm
            </a>
        </li>

        <li>
            <a class="{{ request()->routeIs('admin.categories.create') ? 'active' : '' }}"
               href="{{ route('admin.categories.create') }}">
                <i class="bi bi-plus-square"></i> Thêm loại sản phẩm
            </a>
        </li>

        <li>
            <a class="{{ request()->routeIs('admin.product.*') ? 'active' : '' }}"
               href="{{ route('admin.product.index') }}">
                <i class="bi bi-box-seam"></i> Sản phẩm
            </a>
        </li>

        <li>
            <a class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
               href="{{ route('admin.orders.index') }}">
                <i class="bi bi-bag-check"></i> Đơn hàng
            </a>
        </li>

        <!-- 🔥 POST -->
        <li>
            <a class="{{ request()->routeIs('admin.post.*') ? 'active' : '' }}"
               href="{{ route('admin.post.index') }}">
                <i class="bi bi-file-earmark-text"></i> Bài viết
            </a>
        </li>

        <!-- 🔥 BRAND -->
        <li>
            <a class="{{ request()->routeIs('admin.brand.*') ? 'active' : '' }}"
               href="{{ route('admin.brand.index') }}">
                <i class="bi bi-tags"></i> Thương hiệu
            </a>
        </li>

    </ul>
</div>