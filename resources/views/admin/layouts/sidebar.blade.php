{{-- Menu expand --}}
<li class="nav-item">
    <a class="nav-link text-white" data-bs-toggle="collapse" href="#categoryMenu">
        <i class="bi bi-tags"></i>
        Quản lý
        <i class="bi bi-chevron-down float-end"></i>
    </a>

    <div class="collapse" id="categoryMenu">
        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a class="nav-link text-white"
                   href="{{ route('admin.categories.index') }}">
                    Loại sản phẩm
                </a>
            </li>

            <li class="nav-item">
                ...
            </li>

            <li class="nav-item">
                ...
            </li>
        </ul>
    </div>
</li>