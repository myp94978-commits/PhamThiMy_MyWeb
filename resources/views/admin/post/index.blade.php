@extends('admin.layouts.admin')

@section('title', 'Danh sách bài viết')

@section('content')
<div class="admin-card">
    <h2>DANH SÁCH BÀI VIẾT</h2>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Ảnh</th>
                <th>Tiêu đề</th>
                <th>Chủ đề</th>
                <th>Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    <img src="{{ asset('images/default.png') }}" width="60">
                </td>

                <td>{{ $item->title }}</td>
                <td>{{ $item->username }}</td>
                <td>{{ $item->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection