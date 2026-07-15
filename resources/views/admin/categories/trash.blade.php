
@extends('admin.layouts.admin')

@section('title', 'Trash-Loại Sản phẩm')

@section('content')
<div class="admin-card">
    <h2 class="mb-3">DANH SÁCH LOẠI SẢN PHẨM - ĐANG CHỜ XÓA</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="mb-2">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Quay lại danh sách</a>
        <form action="{{ route('admin.categories.restoreAll') }}" method="POST" class="d-inline ms-2">
            @csrf
            @method('PATCH')
            <button class="btn btn-success">Khôi phục tất cả</button>
        </form>
        <form action="{{ route('admin.categories.forceDeleteAll') }}" method="POST" class="d-inline ms-2">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Xóa vĩnh viễn tất cả?')" class="btn btn-danger">Xóa vĩnh viễn tất cả</button>
        </form>
    </div>

    @if($list->isEmpty())
        <div class="alert alert-warning">Không có mục nào trong thùng rác.</div>
    @else
        <p class="mb-3">Tổng: <strong>{{ $list->total() }}</strong> mục trong thùng rác</p>
        <table class="table table-bordered table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Ảnh</th>
                    <th>Mã loại</th>
                    <th>Tên loại</th>
                    <th>Slug</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
            @foreach($list as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        @if($item->image)
                            <img src="{{ asset('storage/categories/'.$item->image) }}" width="60" alt="{{ $item->catename }}">
                        @else
                            <img src="{{ asset('images/default.png') }}" width="60" alt="no image">
                        @endif
                    </td>
                    <td>{{ $item->cateid }}</td>
                    <td>{{ $item->catename }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>
                        @if($item->status == 1)
                            <span class="badge bg-success">Hiển thị</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.categories.restore', $item->cateid) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm">Khôi phục</button>
                        </form>

                        <form action="{{ route('admin.categories.forceDelete', $item->cateid) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Xóa vĩnh viễn?')" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">{{ $list->links() }}</div>
    @endif

</div>

@endsection
