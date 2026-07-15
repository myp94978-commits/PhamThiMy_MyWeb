{{-- Hiển thị tất cả lỗi Validation --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Hiển thị lỗi từ session flash --}}
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- Hiển thị thông báo từ session flash --}}
@if (session('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
        @if (session('error_detail'))
            <div class="mt-2 small text-muted">
                {{ session('error_detail') }}
            </div>
        @endif
    </div>
@endif

{{-- Hiển thị thông báo thành công --}}
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        @if (session('reset_link'))
            <div class="mt-2">
                <a href="{{ session('reset_link') }}" class="link-primary">Nhấp vào đây để đổi mật khẩu</a>
            </div>
        @endif
    </div>
@endif
