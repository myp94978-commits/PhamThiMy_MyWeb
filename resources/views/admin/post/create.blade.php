<h1>Thêm Post mới</h1>
<form method="POST" action="/admin/post">
    @csrf
    <label>Tiêu đề Post:</label>
    <input type="text" name="title">
    <button type="submit">Lưu</button>
</form>
