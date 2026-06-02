<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand', 'category'])->get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('sort_order')->get();
        $brands = Brand::orderBy('sort_order')->get();
        return view('admin.product.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'productname' => 'required|string|max:150',
            'slug' => 'required|string|max:200|unique:products,slug',
            'price' => 'required|integer|min:0',
            'pricediscount' => 'nullable|integer|min:0',
            'image' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
            'brandid' => 'nullable|exists:brands,id',
            'cateid' => 'nullable|exists:categories,id',
        ]);

        Product::create($request->only([
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image',
            'description',
            'status',
            'brandid',
            'cateid',
        ]));

        return redirect('/admin/product')->with('success', 'Đã thêm Product mới.');
    }

    public function show($id)
    {
        $product = Product::with(['brand', 'category'])->findOrFail($id);
        return view('admin.product.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('sort_order')->get();
        $brands = Brand::orderBy('sort_order')->get();
        return view('admin.product.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'productname' => 'required|string|max:150',
            'slug' => 'required|string|max:200|unique:products,slug,' . $id,
            'price' => 'required|integer|min:0',
            'pricediscount' => 'nullable|integer|min:0',
            'image' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
            'brandid' => 'nullable|exists:brands,id',
            'cateid' => 'nullable|exists:categories,id',
        ]);

        $product->update($request->only([
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image',
            'description',
            'status',
            'brandid',
            'cateid',
        ]));

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
