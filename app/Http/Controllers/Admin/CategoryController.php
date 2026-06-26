<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;




class CategoryController extends Controller
{
    public function index($limit = 10)
    {
        $list = Category::select(
                'cateid',
                'catename',
                'slug',
                'image',
                'status'
            )
            ->orderBy('catename')
            ->paginate($limit);

        return view('admin.categories.index', compact('list'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        try {

            Category::create([
                'catename' => $request->catename,
                'slug' => $request->slug,
                'status' => $request->status ?? 1
            ]);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Thêm danh mục thành công');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $item = Category::find($id);

        return view('admin.categories.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        try {

            $item = Category::find($id);

            if (!$item) {
                return redirect()
                    ->route('admin.categories.index')
                    ->with('error', 'Danh mục không tồn tại');
            }

            $item->update([
                'catename' => $request->catename,
                'slug' => $request->slug,
                'status' => $request->status
            ]);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Cập nhật danh mục thành công');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            $item = Category::find($id);

            if (!$item) {
                return redirect()
                    ->route('admin.categories.index')
                    ->with('error', 'Danh mục không tồn tại');
            }

            $item->delete();

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Xóa danh mục thành công');

        } catch (\Exception $e) {

            return redirect()
                ->route('admin.categories.index')
                ->with('error', $e->getMessage());
        }
    }
}


