<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // Hiển thị danh sách
    public function index()
    {
        $brands = ["Apple", "Samsung", "Sony"];
        return view('admin.brand.index', compact('brands'));
    }

    // Hiển thị form thêm brand
    public function create()
    {
        return view('admin.brand.create');
    }

    // Xử lý dữ liệu form thêm brand
    public function store(Request $request)
    {
        $name = $request->input('name');
        // Tạm thời chỉ test, chưa lưu DB
        return "Bạn vừa thêm Brand: " . $name;
    }

    // Hiển thị chi tiết brand
    public function show($id)
    {
        return "Chi tiết Brand có ID: " . $id;
    }

    // Hiển thị form sửa brand
    public function edit($id)
{
    return view('admin.brand.edit', compact('id'));
}
    // Cập nhật brand
    public function update(Request $request, $id)
{
    $name = $request->input('name');
    return "Brand có ID $id đã được cập nhật thành: " . $name;
}

    // Xóa brand
    public function destroy($id)
    {
        return "Xóa Brand có ID: " . $id;
    }
}
