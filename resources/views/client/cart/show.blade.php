@extends('client.layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
@php
$cart = Session::get('cart', []);
$total = 0;
$totalQuantity = 0;
@endphp

<div class="container py-4">
    <h3 class="mb-4">Giỏ hàng của bạn</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success') || session('error'))
        <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}">
            {{ session('success') ?? session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-5">
            <form id="checkout-form" action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <strong>Thông tin khách hàng</strong>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" name="fullname" class="form-control" required value="{{ old('fullname') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <textarea name="address" rows="3" class="form-control" required>{{ old('address') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="note" rows="3" class="form-control">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Đơn hàng của bạn</strong>
                </div>
                <div class="card-body p-1">
                    @if (count($cart) > 0)
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th width="60">STT</th>
                                    <th width="100">Hình ảnh</th>
                                    <th>Sản phẩm</th>
                                    <th width="120">Đơn giá</th>
                                    <th width="100">Số lượng</th>
                                    <th width="150">Thành tiền</th>
                                    <th width="80">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $item)
                                    @php
                                        $subtotal = $item['price'] * $item['quantity'];
                                        $total += $subtotal;
                                        $totalQuantity += $item['quantity'];
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset('storage/products/' . $item['image']) }}" width="70" class="img-thumbnail">
                                        </td>
                                        <td>{{ $item['productname'] }}</td>
                                        <td class="text-end">{{ number_format($item['price']) }} đ</td>
                                        <td class="text-center">{{ $item['quantity'] }}</td>
                                        <td class="text-end text-danger fw-bold">{{ number_format($subtotal) }} đ</td>
                                        <td class="text-center">
                                            <form action="{{ route('cart.remove', $item['productid']) }}" method="POST" class="d-inline-block remove-cart-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-remove-cart" data-url="{{ route('cart.remove', $item['productid']) }}">
                                                    Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Tổng số lượng</th>
                                    <th class="text-center"><span id="totalQuantity">{{ $totalQuantity }}</span></th>
                                    <th colspan="2"></th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="text-end">Tổng tiền</th>
                                    <th class="text-danger text-end"><span id="total">{{ number_format($total) }} đ</span></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    @else
                        <div class="alert alert-warning">
                            Giỏ hàng đang trống.
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-end mt-3">
                <a href="{{ route('home') }}" class="btn btn-secondary">Quay lại mua hàng</a>
                <button class="btn btn-primary" type="submit" form="checkout-form">Xác nhận đặt hàng</button>
            </div>
        </div>
    </div>
</div>
@endsection
