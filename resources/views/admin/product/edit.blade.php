@extends('admin.layouts.admin')

@section('title', 'Sửa sản phẩm')

@section('content')
<div class="card p-4">

    <h3 class="mb-4">Sửa sản phẩm</h3>

    <x-admin.alert />

    <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-6">

                <div class="mb-3">
                    <label>Tên sản phẩm</label>
                    <input type="text"
                           name="productname"
                           class="form-control"
                           value="{{ old('productname', $product->productname) }}"
                           required>
                    @error('productname')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Slug</label>
                    <input type="text"
                           name="slug"
                           class="form-control"
                           value="{{ old('slug', $product->slug) }}"
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
                                {{ old('cateid', $product->cateid) == $category->cateid ? 'selected' : '' }}>
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
        {{ old('brandid', $product->brandid) == $brand->id ? 'selected' : '' }}>
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
                    <input type="number"
                           name="price"
                           class="form-control"
                           value="{{ old('price', $product->price) }}"
                           required>
                    @error('price')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Giá khuyến mãi</label>
                    <input type="number"
                           name="pricediscount"
                           class="form-control"
                           value="{{ old('pricediscount', $product->pricediscount) }}">
                    @error('pricediscount')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Trạng thái</label><br>

                    <input type="radio"
                           name="status"
                           value="1"
                           {{ old('status', $product->status) == 1 ? 'checked' : '' }}>
                    Hiển thị

                    <input type="radio"
                           name="status"
                           value="0"
                           {{ old('status', $product->status) == 0 ? 'checked' : '' }}>
                    Ẩn
                </div>

                <div class="mb-3">
                    <label>Mô tả sản phẩm</label>
                    <textarea name="description"
                              rows="4"
                              class="form-control">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 img-group">
                    <label>Ảnh chính</label>

                    @if($product->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/products/'.$product->image) }}" width="150" class="img-thumbnail" alt="{{ $product->productname }}">
                        </div>
                    @endif

                    <input type="file" name="img" class="form-control img-input">
                    <div class="img-preview mt-2"></div>
                    @error('img')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 img-group">
                    <label>Ảnh phụ</label>

                    @if($product->images->count())
                        <div class="mb-2">
                            @foreach($product->images as $image)
                                <div class="d-inline-block text-center me-2 mb-2" style="width:120px;">
                                    <img src="{{ asset('storage/product_images/'.$image->image) }}" class="img-thumbnail mb-1" width="100" alt="Ảnh phụ">
                                    <form action="{{ route('admin.product.images.destroy', ['product' => $product->id, 'image' => $image->id]) }}"
                                          method="POST"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa ảnh phụ này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100">Xóa</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <input type="file" name="imgs[]" class="form-control img-input" multiple>
                    <div class="img-preview mt-2"></div>
                    @error('imgs')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    @error('imgs.*')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        </div>

        <button type="submit" class="btn btn-primary">
            Cập nhật sản phẩm
        </button>

        <a href="{{ route('admin.product.index') }}"
           class="btn btn-secondary">
            Quay lại
        </a>

    </form>

</div>
@endsection