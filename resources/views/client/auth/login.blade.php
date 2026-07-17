@extends('client.layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-4">Đăng nhập</h3>

                    @if(session('message'))
                        <div class="alert alert-danger">{{ session('message') }}</div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập hoặc email</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required autofocus>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                    </form>

                    <div class="mt-4 text-center">
                        <span>Chưa có tài khoản?</span>
                        <a href="{{ route('register') }}">Đăng ký ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
