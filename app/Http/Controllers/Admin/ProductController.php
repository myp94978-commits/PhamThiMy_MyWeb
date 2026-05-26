<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = ["Laptop", "Điện thoại", "Máy ảnh"];
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        return "Bạn vừa thêm Product: " . $name;
    }

    public function show($id)
    {
        return "Chi tiết Product có ID: " . $id;
    }

    public function edit($id)
    {
        return view('admin.product.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $name = $request->input('name');
        return "Product có ID $id đã được cập nhật thành: " . $name;
    }

    public function destroy($id)
    {
        return "Xóa Product có ID: " . $id;
    }
}
