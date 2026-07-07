@extends('admin.layouts.admin')

@section('title', 'Thêm thương hiệu')

@section('content')
<div class="admin-card">

    <h2>THÊM THƯƠNG HIỆU</h2>

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

    <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Tên thương hiệu -->
        <div class="mb-3">
            <label>Tên thương hiệu</label>
            <input
                type="text"
                name="brandname"
                class="form-control"
                value="{{ old('brandname') }}"
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
                value="{{ old('slug') }}">

            @error('slug')
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

        <!-- Mô tả -->
        <div class="mb-3">
            <label>Mô tả</label>
            <textarea
                name="description"
                rows="4"
                class="form-control">{{ old('description') }}</textarea>

            @error('description')
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

        <a href="{{ route('admin.brand.index') }}" class="btn btn-secondary">
            Quay lại
        </a>

    </form>

</div>
@endsection