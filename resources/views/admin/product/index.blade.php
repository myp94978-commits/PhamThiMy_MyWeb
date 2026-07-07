@extends('admin.layouts.admin')

@section('title', 'Danh sách sản phẩm')

@section('content')

<div class="admin-card">


<h2>DANH SÁCH SẢN PHẨM</h2>

<a href="{{ route('admin.product.create') }}"
   class="btn btn-primary mb-3">
    Thêm mới
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Loại sản phẩm</th>
            <th>Thương hiệu</th>
            <th>Giá</th>
            <th>Trạng thái</th>
            <th width="120">Thao tác</th>
        </tr>
    </thead>

    <tbody>
    @forelse($list as $item)
        <tr>
            <td>{{ $list->firstItem() + $loop->index }}</td>

            <td>
                @if($item->image)
                    <img src="{{ asset('storage/products/'.$item->image) }}" width="60" class="img-thumbnail" alt="{{ $item->productname }}">
                @else
                    <span class="text-muted">Chưa có</span>
                @endif
            </td>

            <td></td>{{ $item->productname }}</td>

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

            <td>
    <a href="{{ route('admin.product.edit', $item->id) }}"
       class="btn btn-sm btn-success">
        <i class="fas fa-edit"></i>
    </a>

    <form action="{{ route('admin.product.destroy', $item->id) }}"
          method="POST"
          style="display:inline;">
        @csrf
        @method('DELETE')

        <button type="submit"
                class="btn btn-sm btn-danger"
                onclick="return confirm('Bạn có chắc muốn xóa không?')">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</td>
    @empty
        <tr>
            <td colspan="7" class="text-center">
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
