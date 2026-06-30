@extends('admin.layouts.admin')

@section('title', 'Sửa thương hiệu')

@section('content')
<div class="admin-card">

    <h2>SỬA THƯƠNG HIỆU</h2>

    {{-- Hiển thị tất cả lỗi --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.brand.update', $brand->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Tên thương hiệu -->
        <div class="mb-3">
            <label>Tên thương hiệu</label>
            <input
                type="text"
                name="brandname"
                class="form-control"
                value="{{ old('brandname', $brand->brandname) }}"
                required>

            @error('brandname')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Slug -->
        <div class="mb-3">
            <label>Slug</label>
            <input
                type="text"
                name="slug"
                class="form-control"
                value="{{ old('slug', $brand->slug) }}">

            @error('slug')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Mô tả -->
        <div class="mb-3">
            <label>Mô tả</label>
            <textarea
                name="description"
                rows="4"
                class="form-control">{{ old('description', $brand->description) }}</textarea>

            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Trạng thái -->
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

            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
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