<h1>Thêm User mới</h1>
<form method="POST" action="/admin/user">
    @csrf
    <label>Tên User:</label>
    <input type="text" name="name">
    <button type="submit">Lưu</button>
</form>
