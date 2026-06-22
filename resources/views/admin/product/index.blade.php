@extends('admin.layouts.admin')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="admin-card">
    <h2>DANH SÁCH SẢN PHẨM</h2>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Loại sản phẩm</th>
                <th>Thương hiệu</th>
            </tr>
        </thead>
        <tbody>
@forelse($list as $item)
<tr>
    <td>{{ $list->firstItem() + $loop->index }}</td>

    <td>{{ $item->productname }}</td>

    <td>{{ $item->category?->catename }}</td>

    <td>{{ $item->brand?->brandname }}</td>

    <td>{{ number_format($item->price) }}</td>

    <td>
        @if($item->status)
            <span class="badge bg-success">Hiện</span>
        @else
            <span class="badge bg-danger">Ẩn</span>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">
        Không có dữ liệu
    </td>
</tr>
@endforelse
</tbody>
    </table>

    <div class="d-flex justify-content-center">
    {{ $list->links() }}
      </div>
</div>
@endsection