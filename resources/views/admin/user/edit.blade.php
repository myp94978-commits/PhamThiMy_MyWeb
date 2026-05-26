<h1>Sửa User</h1>
<form method="POST" action="/admin/user/{{ $id }}">
    @csrf
    @method('PUT')
    <label>Tên User:</label>
    <input type="text" name="name" value="Tên cũ">
    <button type="submit">Cập nhật</button>
</form>
