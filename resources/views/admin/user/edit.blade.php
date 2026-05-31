<h1>Sửa User</h1>
<form method="POST" action="/admin/user/{{ $user->id }}">
    @csrf
    @method('PUT')
    <label>Tên User:</label>
    <input type="text" name="name" value="{{ old('name', $user->name) }}">
    @error('name')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email', $user->email) }}">
    @error('email')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <label>Mật khẩu mới (nếu muốn):</label>
    <input type="password" name="password">
    @error('password')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <button type="submit">Cập nhật</button>
</form>
