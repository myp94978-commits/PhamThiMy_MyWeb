<h1>Danh sách Category</h1>
<p><a href="/admin/category/create">Thêm Category mới</a></p>
@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
<ul>
    @foreach($categories as $category)
        <li>
            {{ $category->name }}
            <a href="/admin/category/{{ $category->id }}">Xem</a>
            <a href="/admin/category/{{ $category->id }}/edit">Sửa</a>
            <form action="/admin/category/{{ $category->id }}" method="POST" style="display:inline; margin-left:10px;">
                @csrf
                @method('DELETE')
                <button type="submit">Xóa</button>
            </form>
        </li>
    @endforeach
</ul>
