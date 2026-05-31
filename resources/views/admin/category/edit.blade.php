<h1>Sửa Category</h1>
<form method="POST" action="/admin/category/{{ $category->id }}">
    @csrf
    @method('PUT')
    <label>Tên Category:</label>
    <input type="text" name="name" value="{{ old('name', $category->name) }}">
    @error('name')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <button type="submit">Cập nhật</button>
</form>
