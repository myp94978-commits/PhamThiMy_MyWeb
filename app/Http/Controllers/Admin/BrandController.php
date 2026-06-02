<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'brandname' => 'required|string|max:50|unique:brands,brandname',
            'slug' => 'nullable|string|max:150|unique:brands,slug',
            'image' => 'nullable|string|max:255',
            'status' => 'nullable|in:0,1',
            'sort_order' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['brandname', 'image', 'status', 'sort_order', 'description']);
        $data['slug'] = $request->slug ?: Str::slug($request->brandname);

        Brand::create($data);

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
            'brandname' => 'required|string|max:50|unique:brands,brandname,' . $brand->id,
            'slug' => 'nullable|string|max:150|unique:brands,slug,' . $brand->id,
            'image' => 'nullable|string|max:255',
            'status' => 'nullable|in:0,1',
            'sort_order' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['brandname', 'image', 'status', 'sort_order', 'description']);
        $data['slug'] = $request->slug ?: Str::slug($request->brandname);

        $brand->update($data);

        return redirect('/admin/brand')->with('success', 'Đã cập nhật Brand.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect('/admin/brand')->with('success', 'Đã xóa Brand.');
    }
}
