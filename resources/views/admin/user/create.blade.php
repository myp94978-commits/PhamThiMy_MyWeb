@extends('admin.layouts.admin')

@section('title', 'Thêm người dùng')

@section('content')
<div class="admin-card">
    <h2>THÊM NGƯỜI DÙNG</h2>

    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Họ tên</label>
                    <input type="text" name="fullname" class="form-control" value="{{ old('fullname') }}" required>
                    @error('fullname')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                    @error('username')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    @error('phone')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label>Địa chỉ</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    @error('address')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Giới tính</label>
                    <select name="gender" class="form-select" required>
                        <option value="">-- Chọn giới tính --</option>
                        <option value="0" {{ old('gender') === '0' ? 'selected' : '' }}>Nam</option>
                        <option value="1" {{ old('gender') === '1' ? 'selected' : '' }}>Nữ</option>
                        <option value="2" {{ old('gender') === '2' ? 'selected' : '' }}>Khác</option>
                    </select>
                    @error('gender')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Ngày sinh</label>
                    <input type="date" name="birthday" class="form-control" value="{{ old('birthday') }}">
                    @error('birthday')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Vai trò</label>
                    <select name="role" class="form-select" required>
                        <option value="">-- Chọn vai trò --</option>
                        <option value="1" {{ old('role') === '1' ? 'selected' : '' }}>Người dùng</option>
                        <option value="2" {{ old('role') === '2' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Trạng thái</label>
                    <select name="status" class="form-select" required>
                        <option value="">-- Chọn trạng thái --</option>
                        <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Ẩn</option>
                    </select>
                    @error('status')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary ms-2">Quay lại</a>
    </form>
</div>
@endsection