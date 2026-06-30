@extends('admin.layouts.admin')

@section('title', 'Thêm sản phẩm')

@section('content')
<div class="card p-4">

    <h3 class="mb-4">Thêm sản phẩm</h3>

    <x-admin.alert />

    <form action="{{ route('admin.product.store') }}" method="POST">
        @csrf

        <div class="row">

            <div class="col-md-6">

                <div class="mb-3">
                    <label>Tên sản phẩm</label>
                    <input type="text" name="productname"
                           class="form-control"
                           value="{{ old('productname') }}"
                           required>
                    @error('productname')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Slug</label>
                    <input type="text" name="slug"
                           class="form-control"
                           value="{{ old('slug') }}"
                           required>
                    @error('slug')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Loại sản phẩm</label>
                    <select name="cateid" class="form-select">
                        <option value="">-- Chọn loại sản phẩm --</option>

                        @foreach($categories as $category)
                           <option value="{{ $category->cateid }}"
                               {{ old('cateid') == $category->cateid ? 'selected' : '' }}>
                                          {{ $category->catename }}
                            </option>
                        @endforeach

                    </select>
                    @error('cateid')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Thương hiệu</label>
                    <select name="brandid" class="form-select">
                        <option value="">-- Chọn thương hiệu --</option>

                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}"
                               {{ old('brandid') == $brand->id ? 'selected' : '' }}>
                                      {{ $brand->brandname }}
                             </option>
                        @endforeach

                    </select>
                    @error('brandid')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="col-md-6">

                <div class="mb-3">
                    <label>Giá</label>
                    <input type="number" name="price"
                           class="form-control"
                           value="{{ old('price') }}"
                           required>
                    @error('price')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Giá khuyến mãi</label>
                    <input type="number" name="pricediscount"
                           class="form-control"
                           value="{{ old('pricediscount',0) }}">
                    @error('pricediscount')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Trạng thái</label><br>

                    <input type="radio"
                   name="status"
                   value="1"
                    {{ old('status',1) == 1 ? 'checked' : '' }}>
                         Hiển thị

             <input type="radio"
                 name="status"
                 value="0"
                  {{ old('status',1) == 0 ? 'checked' : '' }}>
                    Ẩn
                </div>

                <div class="mb-3">
                    <label>Mô tả sản phẩm</label>
                    <textarea name="description"
                              rows="4"
                              class="form-control">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>

        </div>

        <button type="submit" class="btn btn-primary">
            Lưu sản phẩm
        </button>

        <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
            Quay lại
        </a>

    </form>

</div>
@endsection