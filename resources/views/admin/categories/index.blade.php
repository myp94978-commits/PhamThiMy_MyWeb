@extends('admin.layouts.admin')

@section('title', 'Danh sách loại sản phẩm')

@section('content')
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">DANH SÁCH LOẠI SẢN PHẨM</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
        + Thêm mới
    </a>
    </div>

    @if($list->isEmpty())
        <div class="alert alert-warning">
            Không có loại sản phẩm nào để hiển thị.
        </div>
    @else
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
                <img src="{{ asset('images/default.png') }}" width="60">
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
            

            <!-- 🔥 CỘT CHỨC NĂNG -->
           <td>
    <a href="{{ route('admin.categories.edit', $item->cateid) }}"
       class="btn btn-warning btn-sm">
        Sửa
    </a>

    <form action="{{ route('admin.categories.destroy', $item->cateid) }}"
          method="POST"
          style="display:inline;">
        @csrf
        @method('DELETE')

        <button type="submit"
                class="btn btn-danger btn-sm"
                onclick="return confirm('Bạn có chắc muốn xóa?')">
            Xóa
        </button>
    </form>
</td>

        </tr>
    @endforeach
</tbody>
        </table>
    @endif
</div>
@endsection