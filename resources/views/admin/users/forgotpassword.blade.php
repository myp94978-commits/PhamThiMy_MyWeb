<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quên mật khẩu</title>
    
    <!-- CDN Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <form action="{{ route('admin.forgotpass.post') }}" method="POST" class="mx-auto shadow-lg p-4 w-50 bg-light">
            @csrf

            <h2>Quên mật khẩu</h2>

            <x-admin.alert></x-admin.alert>

            <div class="mb-3 mt-3">
                <label for="f-email">Email</label>
                <input type="text" class="form-control" id="f-email" placeholder="" 
                       name="email" value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Hành động</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="action" id="action-random" value="random_password" {{ old('action') === 'random_password' ? 'checked' : '' }}>
                    <label class="form-check-label" for="action-random">
                        Gửi mật khẩu ngẫu nhiên mới qua email
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="action" id="action-reset" value="reset_link" {{ old('action') === 'reset_link' ? 'checked' : '' }}>
                    <label class="form-check-label" for="action-reset">
                        Gửi liên kết đặt lại mật khẩu kèm OTP
                    </label>
                </div>
                @error('action')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 mt-3 d-flex gap-1">
                <button type="submit" class="btn btn-primary">Gửi</button>
                <a href="{{ route('admin.login') }}" class="btn btn-warning">Đăng nhập</a>
            </div>

        </form>
    </div>
</body>
</html>
