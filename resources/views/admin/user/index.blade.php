<h1>Danh sách User</h1>
<p><a href="/admin/user/create">Thêm User mới</a></p>
@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
<ul>
    @foreach($users as $user)
        <li>
            {{ $user->name }} - {{ $user->email }}
            <a href="/admin/user/{{ $user->id }}">Xem</a>
            <a href="/admin/user/{{ $user->id }}/edit">Sửa</a>
            <form action="/admin/user/{{ $user->id }}" method="POST" style="display:inline; margin-left:10px;">
                @csrf
                @method('DELETE')
                <button type="submit">Xóa</button>
            </form>
        </li>
    @endforeach
</ul>
