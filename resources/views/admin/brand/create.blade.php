@extends('admin.layouts.admin')

@section('title', 'Thêm thương hiệu')

@section('content')
<div class="admin-card">

    <h2>THÊM THƯƠNG HIỆU</h2>

    <form action="{{ route('admin.brand.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Tên thương hiệu</label>
            <input type="text" name="brandname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control">
        </div>

        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-control">
                <option value="1">Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Lưu
        </button>
    </form>

</div>
@endsection