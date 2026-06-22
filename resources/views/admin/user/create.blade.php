@extends('admin.layouts.admin')

@section('title', 'Thêm người dùng')

@section('content')
<div class="admin-card">
    <h2>THÊM NGƯỜI DÙNG</h2>

    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Họ tên</label>
            <input type="text" name="fullname" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">
            Lưu
        </button>
    </form>
</div>
@endsection