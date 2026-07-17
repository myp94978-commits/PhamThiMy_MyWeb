<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display the shopping cart page
     */
    public function show()
    {
        return view('client.cart.show');
    }

    /**
     * Add product to cart (session)
     */
    public function addToCart(Request $request, $id)
    {
        $product = Product::select(
            'id',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image'
        )->findOrFail($id);

        $quantity = max(1, (int) $request->input('quantity', 1));
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'productid' => $product->id,
                'productname' => $product->productname,
                'slug' => $product->slug,
                'image' => $product->image,
                'price' => $product->pricediscount ?: $product->price,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        $responseData = [
            'status' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng.',
            'cartCount' => collect($cart)->sum('quantity'),
        ];

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($responseData);
        }

        return redirect()->back()->with('success', $responseData['message']);
    }

    /**
     * Remove product from cart
     */
    public function removeCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        if (empty($cart)) {
            session()->forget('cart');
        } else {
            session()->put('cart', $cart);
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $responseData = [
            'status' => true,
            'message' => 'Đã xóa sản phẩm.',
            'cartCount' => collect($cart)->sum('quantity'),
            'total' => $total,
            'isEmpty' => empty($cart),
        ];

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json($responseData);
        }

        return redirect()->back()->with('success', $responseData['message']);
    }

    /**
     * Handle checkout form submission
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'required|string|max:500',
            'note' => 'nullable|string|max:1000',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng đang trống.');
        }

        DB::beginTransaction();

        try {
            $customer = Customer::where('phone', $request->phone)->first();

            if (empty($customer)) {
                $customer = Customer::create([
                    'full_name' => $request->fullname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => '',
                    'postal_code' => '',
                ]);
            }

            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            $order = Order::create([
                'customer_id' => $customer->id,
                'order_code' => 'DH' . time(),
                'subtotal' => $total,
                'shipping' => 0,
                'tax' => 0,
                'total' => $total,
                'payment_method' => 'cod',
                'status' => '0',
                'notes' => $request->note,
            ]);

            $orderItems = [];
            foreach ($cart as $item) {
                $orderItems[] = [
                    'order_id' => $order->id,
                    'product_id' => $item['productid'],
                    'product_name' => $item['productname'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            OrderItem::insert($orderItems);

            DB::commit();

            session()->forget('cart');

            return redirect()->route('cart.show')->with('success', 'Đặt hàng thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.');
        }
    }

    /**
     * Create order from session cart and checkout
     */
    public function storeOrder(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'nullable|string',
            'payment_method' => 'required|in:cod,bank',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required_without:items.*.productid|integer',
            'items.*.name' => 'required_without:items.*.productname|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $cart = collect($request->input('items', session()->get('cart', [])))->map(function ($item) {
            return [
                'productid' => $item['productid'] ?? $item['id'] ?? null,
                'productname' => $item['productname'] ?? $item['name'] ?? $item['title'] ?? null,
                'price' => isset($item['price']) ? (float) $item['price'] : 0,
                'quantity' => isset($item['quantity']) ? (int) $item['quantity'] : 0,
            ];
        })->filter(function ($item) {
            return $item['productid'] && $item['productname'] && $item['quantity'] > 0;
        });

        if ($cart->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Giỏ hàng trống.',
            ], 422);
        }

        $order = DB::transaction(function () use ($request, $cart) {
            $customer = Customer::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
            ]);

            $subtotal = $cart->sum(fn($item) => $item['price'] * $item['quantity']);
            $shipping = $subtotal > 0 ? 30000 : 0;
            $tax = floor($subtotal * 0.1);
            $total = $subtotal + $shipping + $tax;

            $order = Order::create([
                'customer_id' => $customer->id,
                'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['productid'],
                    'product_name' => $item['productname'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return response()->json([
            'status' => true,
            'message' => 'Đặt hàng thành công. Mã đơn hàng: ' . $order->order_code,
            'order_code' => $order->order_code,
        ]);
    }
}
