<h1>Sửa Post</h1>
<form method="POST" action="/admin/post/{{ $post->id }}">
    @csrf
    @method('PUT')
    <label>Tiêu đề Post:</label>
    <input type="text" name="title" value="{{ old('title', $post->title) }}">
    @error('title')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <button type="submit">Cập nhật</button>
</form>
