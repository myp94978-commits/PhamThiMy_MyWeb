@extends('admin.layouts.admin')

@section('title', 'Thêm loại sản phẩm')

@section('content')
<div class="admin-card">

    <h2>THÊM LOẠI SẢN PHẨM</h2>

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

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Tên loại sản phẩm -->
        <div class="mb-3">
            <label>Tên loại sản phẩm</label>
            <input
                type="text"
                name="catename"
                class="form-control"
                value="{{ old('catename') }}"
                required>

            @error('catename')
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
                value="{{ old('slug') }}"
                required>

            @error('slug')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Mô tả sản phẩm -->
        <div class="mb-3">
            <label>Mô tả sản phẩm</label>
            <textarea
                name="description"
                class="form-control"
                rows="4">{{ old('description') }}</textarea>

            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Hình ảnh -->
        <div class="mb-3 img-group">
            <label>Hình ảnh</label>
            <input
                type="file"
                name="img"
                class="form-control img-input">

            <div class="img-preview mt-2"></div>

            @error('img')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Trạng thái -->
        <div class="mb-3">
            <label>Trạng thái</label>

            <select name="status" class="form-control">
                <option value="1" {{ old('status',1)==1 ? 'selected' : '' }}>
                    Hiển thị
                </option>

                <option value="0" {{ old('status')==0 ? 'selected' : '' }}>
                    Ẩn
                </option>
            </select>

            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Lưu
        </button>

        <a href="{{ route('admin.categories.index') }}"
           class="btn btn-secondary">
            Quay lại
        </a>

    </form>

</div>
@endsection