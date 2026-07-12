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
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="nhập email" 
                       name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Gửi liên kết</button>
            
            <a href="{{ route('admin.login') }}">Quay lại đăng nhập</a>
        </form>
    </div>
</body>
</html>
