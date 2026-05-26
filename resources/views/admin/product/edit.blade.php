<h1>Sửa Product</h1>
<form method="POST" action="/admin/product/{{ $id }}">
    @csrf
    @method('PUT')
    <label>Tên Product:</label>
    <input type="text" name="name" value="Tên cũ">
    <button type="submit">Cập nhật</button>
</form>
