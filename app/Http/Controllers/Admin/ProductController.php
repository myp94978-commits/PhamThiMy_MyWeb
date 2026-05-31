<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Product::create($request->only('name'));

        return redirect('/admin/product')->with('success', 'Đã thêm Product mới.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $product->update($request->only('name'));

        return redirect('/admin/product')->with('success', 'Đã cập nhật Product.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect('/admin/product')->with('success', 'Đã xóa Product.');
    }

    public function test1(): RedirectResponse
    {
        return redirect()->route('admin.home');
    }

    public function test2(): RedirectResponse
    {
        return redirect('/admin/dashboard');
    }
}
