<h1>Sửa Product</h1>
<form method="POST" action="/admin/product/{{ $product->id }}">
    @csrf
    @method('PUT')
    <label>Tên Product:</label>
    <input type="text" name="name" value="{{ old('name', $product->name) }}">
    @error('name')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <button type="submit">Cập nhật</button>
</form>
