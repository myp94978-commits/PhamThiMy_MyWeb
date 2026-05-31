<h1>Thêm Product mới</h1>
<form method="POST" action="/admin/product">
    @csrf
    <label>Tên Product:</label>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <button type="submit">Lưu</button>
</form>
