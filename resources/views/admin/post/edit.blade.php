<h1>Sửa Post</h1>
<form method="POST" action="/admin/post/{{ $id }}">
    @csrf
    @method('PUT')
    <label>Tiêu đề Post:</label>
    <input type="text" name="title" value="Tiêu đề cũ">
    <button type="submit">Cập nhật</button>
</form>
