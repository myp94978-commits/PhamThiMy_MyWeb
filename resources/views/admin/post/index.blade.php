<h1>Danh sách Post</h1>
<p><a href="/admin/post/create">Thêm Post mới</a></p>
@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
<ul>
    @foreach($posts as $post)
        <li>
            {{ $post->title }}
            <a href="/admin/post/{{ $post->id }}">Xem</a>
            <a href="/admin/post/{{ $post->id }}/edit">Sửa</a>
            <form action="/admin/post/{{ $post->id }}" method="POST" style="display:inline; margin-left:10px;">
                @csrf
                @method('DELETE')
                <button type="submit">Xóa</button>
            </form>
        </li>
    @endforeach
</ul>
