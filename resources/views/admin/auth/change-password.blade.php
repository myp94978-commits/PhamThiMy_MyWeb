@extends('admin.layouts.admin')

@section('title', 'Đổi mật khẩu')

@section('content')
    <div class="admin-card">
        <h2>Đổi mật khẩu</h2>

        <x-admin.alert></x-admin.alert>

        <form action="{{ route('admin.change-password.post') }}" method="POST" class="mt-4">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" class="form-control" value="{{ Auth::user()->username }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Họ và tên</label>
                <input type="text" class="form-control" value="{{ Auth::user()->fullname }}" readonly>
            </div>

            <div class="mb-3">
                <label for="old_password" class="form-label">Mật khẩu cũ</label>
                <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Nhập mật khẩu cũ">
                @error('old_password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu mới</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu mới">
                @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu mới">
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
        </form>
    </div>
@endsection
