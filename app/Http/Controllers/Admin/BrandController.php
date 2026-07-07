<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index($limit = 10)
    {
        $list = Brand::orderBy('brandname')
            ->paginate($limit);

        return view('admin.brand.index', compact('list'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(BrandRequest $request)
    {
        try {

            $imagePath = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->brandname) . '-' . time() . '.' . $file->extension();
                $file->storeAs('brands', $fileName, 'public');
                $imagePath = 'brands/' . $fileName;
            }

            Brand::create([
                'brandname' => $request->brandname,
                'slug' => $request->slug ?: Str::slug($request->brandname),
                'description' => $request->description,
                'image' => $imagePath,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.brand.index')
                ->with('success', 'Thêm thương hiệu thành công');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $brand = Brand::findOrFail($id);

        return view('admin.brand.show', compact('brand'));
    }

    public function edit($id)
    {
        $brand = Brand::find($id);

        if (! $brand) {
            return redirect()
                ->route('admin.brand.index')
                ->with('error', 'Thương hiệu không tồn tại.');
        }

        return view('admin.brand.edit', compact('brand'));
    }

    public function update(BrandRequest $request, $id)
    {
        try {

            $brand = Brand::findOrFail($id);

            $fileName = $brand->image;

            if ($request->hasFile('img')) {
                if ($fileName) {
                    Storage::disk('public')->delete($fileName);
                }

                $file = $request->file('img');
                $newFileName = Str::slug($request->brandname) . '-' . time() . '.' . $file->extension();
                $file->storeAs('brands', $newFileName, 'public');
                $fileName = 'brands/' . $newFileName;
            }

            $brand->update([
                'brandname' => $request->brandname,
                'slug' => $request->slug ?: Str::slug($request->brandname),
                'description' => $request->description,
                'status' => $request->status,
                'image' => $fileName,
            ]);

            return redirect()
                ->route('admin.brand.index')
                ->with('success', 'Cập nhật thương hiệu thành công');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            $brand = Brand::findOrFail($id);

            $brand->delete();

            return redirect()
                ->route('admin.brand.index')
                ->with('success', 'Xóa thương hiệu thành công');

        } catch (\Exception $e) {

            return redirect()
                ->route('admin.brand.index')
                ->with('error', $e->getMessage());
        }
    }
}

