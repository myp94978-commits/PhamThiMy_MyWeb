<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer')->latest();

        if ($search = $request->query('search')) {
            $query->where(function ($query) use ($search) {
                $query->where('order_code', 'like', "%{$search}%")
                    ->orWhere('payment_method', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('full_name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $statsQuery = clone $query;

        $orders = $query->paginate(15)->withQueryString();

        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total');
        $filteredRevenue = $statsQuery->sum('total');

        return view('admin.order.index', compact(
            'orders',
            'totalOrders',
            'totalRevenue',
            'filteredRevenue'
        ));
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
