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
            @forelse($list as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    @php
                        $img = $item->image ?? '';
                        $imgPath = public_path('images/' . $img);
                        $imgUrl = ( $img && file_exists($imgPath) ) ? asset('images/' . $img) : asset('images/default.png');
                    @endphp
                    <img src="{{ $imgUrl }}" width="60" alt="">
                </td>

                <td>{{ $item->title }}</td>
                <td>{{ $item->username }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Không có bài viết</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection