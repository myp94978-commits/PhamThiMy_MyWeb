@extends('admin.layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="admin-card">
    <h3 class="mb-4">Chi tiết đơn hàng</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Thông tin khách hàng</h5>
                <p><strong>Họ tên:</strong> {{ $order->customer->full_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer->email }}</p>
                <p><strong>Điện thoại:</strong> {{ $order->customer->phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->customer->address }}, {{ $order->customer->city }}</p>
                <p><strong>Mã bưu chính:</strong> {{ $order->customer->postal_code ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Thông tin đơn hàng</h5>
                <p><strong>Mã đơn:</strong> {{ $order->order_code }}</p>
                <p><strong>Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Trạng thái:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Phương thức:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Subtotal:</strong> {{ number_format($order->subtotal, 0, ',', '.') }}₫</p>
                <p><strong>Shipping:</strong> {{ number_format($order->shipping, 0, ',', '.') }}₫</p>
                <p><strong>Tax:</strong> {{ number_format($order->tax, 0, ',', '.') }}₫</p>
                <p><strong>Tổng:</strong> {{ number_format($order->total, 0, ',', '.') }}₫</p>
                <p><strong>Ghi chú:</strong> {{ $order->notes ?? 'Không có' }}</p>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Sản phẩm</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->subtotal, 0, ',', '.') }}₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
            </div>
        </div>
    </form>
</div>
@endsection
