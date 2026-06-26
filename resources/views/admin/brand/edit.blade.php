@extends('admin.layouts.admin')

@section('title', 'Sửa thương hiệu')

@section('content')

<div class="admin-card">

```
<h2>SỬA THƯƠNG HIỆU</h2>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('admin.brand.update', $brand->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Tên thương hiệu</label>
        <input type="text"
               name="brandname"
               class="form-control"
               value="{{ old('brandname', $brand->brandname) }}"
               required>
    </div>

    <div class="mb-3">
        <label>Slug</label>
        <input type="text"
               name="slug"
               class="form-control"
               value="{{ old('slug', $brand->slug) }}">
    </div>

    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1"
                {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>
                Hiển thị
            </option>

            <option value="0"
                {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>
                Ẩn
            </option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Cập nhật
    </button>

    <a href="{{ route('admin.brand.index') }}"
       class="btn btn-secondary">
        Quay lại
    </a>

</form>


</div>
@endsection
