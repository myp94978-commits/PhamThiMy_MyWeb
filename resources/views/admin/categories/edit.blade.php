@extends('admin.layouts.admin')

@section('content')
<h2>Sửa loại sản phẩm</h2>

<form action="{{ route('admin.categories.update', $item->cateid) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Tên loại sản phẩm</label>
        <input type="text" name="catename"
               value="{{ $item->catename }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Slug</label>
        <input type="text" name="slug"
               value="{{ $item->slug }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>
                Hiển thị
            </option>
            <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>
                Ẩn
            </option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Cập nhật
    </button>
</form>
@endsection