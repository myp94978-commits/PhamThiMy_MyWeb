@extends('admin.layouts.admin')

@section('title', 'Sửa loại sản phẩm')

@section('content')
<div class="admin-card">

    <h2>SỬA LOẠI SẢN PHẨM</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $item->cateid) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Tên loại -->
        <div class="mb-3">
            <label>Tên loại sản phẩm</label>
            <input type="text"
                   name="catename"
                   class="form-control"
                   value="{{ old('catename', $item->catename) }}">

            @error('catename')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Slug -->
        <div class="mb-3">
            <label>Slug</label>
            <input type="text"
                   name="slug"
                   class="form-control"
                   value="{{ old('slug', $item->slug) }}">

            @error('slug')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Trạng thái -->
        <div class="mb-3">
            <label>Trạng thái</label>

            <select name="status" class="form-control">
                <option value="1"
                    {{ old('status', $item->status) == 1 ? 'selected' : '' }}>
                    Hiển thị
                </option>

                <option value="0"
                    {{ old('status', $item->status) == 0 ? 'selected' : '' }}>
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

        <a href="{{ route('admin.categories.index') }}"
           class="btn btn-secondary">
            Quay lại
        </a>

    </form>

</div>
@endsection