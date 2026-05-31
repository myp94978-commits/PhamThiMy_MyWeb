<h1>Danh sách Product</h1>
<p><a href="/admin/product/create">Thêm Product mới</a></p>
@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
<ul>
    @foreach($products as $product)
        <li>
            {{ $product->name }}
            <a href="/admin/product/{{ $product->id }}">Xem</a>
            <a href="/admin/product/{{ $product->id }}/edit">Sửa</a>
            <form action="/admin/product/{{ $product->id }}" method="POST" style="display:inline; margin-left:10px;">
                @csrf
                @method('DELETE')
                <button type="submit">Xóa</button>
            </form>
        </li>
    @endforeach
</ul>
