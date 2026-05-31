<h1>Thêm Post mới</h1>
<form method="POST" action="/admin/post">
    @csrf
    <label>Tiêu đề Post:</label>
    <input type="text" name="title" value="{{ old('title') }}">
    @error('title')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <button type="submit">Lưu</button>
</form>
