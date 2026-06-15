@extends('admin.layouts.admin')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="admin-card">
    <h2>DANH SÁCH SẢN PHẨM</h2>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Loại sản phẩm</th>
                <th>Thương hiệu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    <img src="{{ asset('images/default.png') }}" width="60">
                </td>

                <td>{{ $item->productname }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->catename }}</td>
                <td>{{ $item->brandname }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection