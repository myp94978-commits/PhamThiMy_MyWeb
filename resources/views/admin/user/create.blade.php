<h1>Thêm User mới</h1>
<form method="POST" action="/admin/user">
    @csrf
    <label>Tên User:</label>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email') }}">
    @error('email')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <label>Mật khẩu:</label>
    <input type="password" name="password">
    @error('password')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <button type="submit">Lưu</button>
</form>
