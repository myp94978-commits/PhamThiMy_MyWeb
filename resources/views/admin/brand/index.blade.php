<h1>Danh sách Brand</h1>
<p><a href="/admin/brand/create">Thêm Brand mới</a></p>
@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
<ul>
    @foreach($brands as $brand)
        <li>
            {{ $brand->name }}
            <a href="/admin/brand/{{ $brand->id }}">Xem</a>
            <a href="/admin/brand/{{ $brand->id }}/edit">Sửa</a>
            <form action="/admin/brand/{{ $brand->id }}" method="POST" style="display:inline; margin-left:10px;">
                @csrf
                @method('DELETE')
                <button type="submit">Xóa</button>
            </form>
        </li>
    @endforeach
</ul>
