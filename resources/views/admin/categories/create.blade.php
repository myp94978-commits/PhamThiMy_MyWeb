@extends('admin.layouts.admin')

@section('title', 'Thêm loại sản phẩm')

@section('content')
<div class="admin-card">

    <h2>THÊM LOẠI SẢN PHẨM</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <!-- Tên loại sản phẩm -->
        <div class="mb-3">
            <label>Tên loại sản phẩm</label>
            <input type="text" name="catename" class="form-control" required>
        </div>

       <!-- Slug -->
<div class="mb-3">
    <label>Slug</label>
    <input type="text" name="slug" class="form-control" required>
</div>

<!-- Trạng thái -->
<div class="mb-3">
    <label>Trạng thái</label>
    <select name="status" class="form-control">
        <option value="1">Hiển thị</option>
        <option value="0">Ẩn</option>
    </select>
</div>

        <!-- Button -->
        <button type="submit" class="btn btn-primary">
            Lưu
        </button>

        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            Quay lại
        </a>

    </form>

</div>
@endsection