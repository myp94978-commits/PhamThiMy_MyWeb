@extends('admin.layouts.admin')

@section('title', 'Danh sách thương hiệu')

@section('content')
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">DANH SÁCH THƯƠNG HIỆU</h2>
    </div>

    @if($list->isEmpty())
        <div class="alert alert-warning">
            Không có thương hiệu nào để hiển thị.
        </div>
    @else
        <table class="table table-bordered table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Ảnh</th>
                    <th>Tên thương hiệu</th>
                    <th>Slug</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach($list as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>

                        <td>
                            <img src="{{ asset('images/default.png') }}" width="60">
                        </td>

                        <td>{{ $item->brandname }}</td>
                        <td>{{ $item->slug }}</td>

                        <td>
                            @if($item->status == 1)
                                <span class="badge bg-success">Hiển thị</span>
                            @else
                                <span class="badge bg-danger">Ẩn</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $list->links() }}
        </div>

    @endif
</div>
@endsection