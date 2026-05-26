<h1>Sửa Brand</h1>
<form method="POST" action="/admin/brand/{{ $id }}">
    @csrf
    @method('PUT')
    <label>Tên Brand:</label>
    <input type="text" name="name" value="Tên cũ">
    <button type="submit">Cập nhật</button>
</form>
