@extends('admin.layouts.admin')

@section('title', 'Danh sách người dùng')

@section('content')
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>DANH SÁCH NGƯỜI DÙNG</h2>
        <a href="{{ route('admin.user.create') }}" class="btn btn-primary">Thêm người dùng</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Ảnh</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    <img src="{{ asset('images/default.png') }}" width="60">
                </td>

                <td>{{ $item->fullname }}</td>
                <td>{{ $item->email }}</td>

                <td>
                    @if($item->status == 1)
                        Hiển thị
                    @else
                        Ẩn
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    ...
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $list->links() }}
    </div>
</div>
@endsection