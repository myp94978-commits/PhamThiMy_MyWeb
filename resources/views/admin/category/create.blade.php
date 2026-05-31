<h1>Thêm Category mới</h1>
<form method="POST" action="/admin/category">
    @csrf
    <label>Tên Category:</label>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <button type="submit">Lưu</button>
</form>
