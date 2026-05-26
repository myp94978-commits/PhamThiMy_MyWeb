<h1>Thêm Product mới</h1>
<form method="POST" action="/admin/product">
    @csrf
    <label>Tên Product:</label>
    <input type="text" name="name">
    <button type="submit">Lưu</button>
</form>
