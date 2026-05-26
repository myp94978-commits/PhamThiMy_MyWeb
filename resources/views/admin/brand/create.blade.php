<h1>Thêm Brand mới</h1>
<form method="POST" action="/admin/brand">
    @csrf
    <label>Tên Brand:</label>
    <input type="text" name="name">
    <button type="submit">Lưu</button>
</form>
