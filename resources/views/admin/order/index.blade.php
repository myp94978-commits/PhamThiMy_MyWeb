@extends('admin.layouts.admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
<div class="admin-card">
    <h3 class="mb-4">Danh sách đơn hàng</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card p-3 border-secondary">
                <div class="text-muted">Tổng số đơn hàng</div>
                <h4 class="mt-2">{{ number_format($totalOrders) }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 border-secondary">
                <div class="text-muted">Tổng doanh thu</div>
                <h4 class="mt-2">{{ number_format($totalRevenue, 0, ',', '.') }}₫</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 border-secondary">
                <div class="text-muted">Doanh thu bộ lọc</div>
                <h4 class="mt-2">{{ number_format($filteredRevenue, 0, ',', '.') }}₫</h4>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Tìm mã đơn, khách hàng, điện thoại, email, trạng thái">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Lọc trạng thái --</option>
                @foreach(['pending','processing','shipped','completed','cancelled'] as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Tìm</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">Xóa lọc</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Mã Đơn</th>
                    <th>Khách Hàng</th>
                    <th>Thanh Toán</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Tạo</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->order_code }}</td>
                        <td>
                            <strong>{{ $order->customer->full_name }}</strong><br>
                            <small>{{ $order->customer->phone }}</small><br>
                            <small>{{ $order->customer->email }}</small>
                        </td>
                        <td>{{ strtoupper($order->payment_method) }}</td>
                        <td>{{ number_format($order->total, 0, ',', '.') }}₫</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                Xem
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Không có đơn hàng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
