@extends('client.layouts.app')

@section('title', $products->first()?->catename)

@section('content')
<div class="container py-4">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Sản Phẩm</a></li>
            <li class="breadcrumb-item active">{{ $products->first()?->catename ?? 'Danh mục' }}</li>
        </ol>
    </nav>

    <h3 class="mb-4">
        Danh mục: {{ $products->first()?->catename ?? 'Không xác định' }}
    </h3>

    <div class="row g-4">
        @foreach ($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <x-client.product :product="$product" />
            </div>
        @endforeach
    </div>

    {{-- phân trang --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection

