@extends('admin.layouts.admin')

@section('title', 'Đặt lại mật khẩu')

@section('content')
    <div class="admin-card">
        <h2>Đặt lại mật khẩu</h2>

        <x-admin.alert></x-admin.alert>

        <form action="{{ route('admin.password.reset.post') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $email) }}" readonly>
                @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="otp" class="form-label">Mã OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" value="{{ old('otp') }}" placeholder="Nhập mã OTP từ email">
                @error('otp')
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
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu mới">
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
        </form>
    </div>
@endsection
