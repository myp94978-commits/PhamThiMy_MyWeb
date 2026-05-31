<h1>Sửa Brand</h1>
<form method="POST" action="/admin/brand/{{ $brand->id }}">
    @csrf
    @method('PUT')
    <label>Tên Brand:</label>
    <input type="text" name="name" value="{{ old('name', $brand->name) }}">
    @error('name')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <button type="submit">Cập nhật</button>
</form>
