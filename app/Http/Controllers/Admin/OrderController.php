<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->latest()->paginate(15);

        return view('admin.order.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('customer', 'items.product')->findOrFail($id);

        return view('admin.order.show', compact('order'));
    }

    public function updateStatus($id)
    {
        $order = Order::findOrFail($id);
        $order->status = request('status', $order->status);
        $order->save();

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }
}
