<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Brand::create($request->only('name'));

        return redirect('/admin/brand')->with('success', 'Đã thêm Brand mới.');
    }

    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand.show', compact('brand'));
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $brand->update($request->only('name'));

        return redirect('/admin/brand')->with('success', 'Đã cập nhật Brand.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect('/admin/brand')->with('success', 'Đã xóa Brand.');
    }
}
