<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index($limit = 10)
    {
        $list = Category::select(
            'cateid',
            'catename',
            'slug',
            'description',
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
        $request->validate(
            [
                'catename' => 'required|min:3|max:100|unique:categories,catename',
                'slug' => [
                    'required',
                    'min:5',
                    'max:150',
                    'unique:categories,slug',
                    'regex:/^[a-z0-9-]+$/'
                ],
                'description' => 'nullable|max:255',
                'img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:200',
                'status' => 'required|in:0,1',
            ],
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'max' => ':attribute không vượt quá :max ký tự.',
                'unique' => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'img.image' => ':attribute phải là hình ảnh.',
                'img.mimes' => ':attribute chỉ chấp nhận các định dạng: jpg, jpeg, png, webp.',
                'img.max' => ':attribute không được vượt quá 200 KB.',
                'status.in' => ':attribute không hợp lệ.',
            ],
            [
                'catename' => 'Tên loại',
                'slug' => 'Đường dẫn (Slug)',
                'description' => 'Mô tả',
                'img' => 'Hình ảnh',
                'status' => 'Trạng thái',
            ]
        );

        try {

            $imageName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $imageName = Str::slug($request->catename) . '-' . time() . '.' . $file->extension();
                $file->storeAs('categories', $imageName, 'public');
            }

            Category::create([
                'catename' => $request->catename,
                'slug' => $request->slug,
                'description' => $request->description,
                'image' => $imageName,
                'status' => $request->status
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
        $item = Category::findOrFail($id);

        return view('admin.categories.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'catename' => [
                    'required',
                    'min:3',
                    'max:100',
                    Rule::unique('categories', 'catename')->ignore($id, 'cateid'),
                ],

                'slug' => [
                    'required',
                    'min:5',
                    'max:150',
                    'regex:/^[a-z0-9-]+$/',
                    Rule::unique('categories', 'slug')->ignore($id, 'cateid'),
                ],

                'description' => 'nullable|max:255',
                'img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:200',
                'status' => 'required|in:0,1',
            ],
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'max' => ':attribute không vượt quá :max ký tự.',
                'unique' => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'img.image' => ':attribute phải là hình ảnh.',
                'img.mimes' => ':attribute chỉ chấp nhận các định dạng: jpg, jpeg, png, webp.',
                'img.max' => ':attribute không được vượt quá 200 KB.',
                'status.in' => ':attribute không hợp lệ.',
            ],
            [
                'catename' => 'Tên loại',
                'slug' => 'Đường dẫn (Slug)',
                'description' => 'Mô tả',
                'img' => 'Hình ảnh',
                'status' => 'Trạng thái',
            ]
        );

        try {

            $item = Category::findOrFail($id);
            $imageName = $item->image;

            if ($request->hasFile('img')) {
                if ($imageName) {
                    Storage::disk('public')->delete('categories/'.$imageName);
                }

                $file = $request->file('img');
                $imageName = Str::slug($request->catename) . '-' . time() . '.' . $file->extension();
                $file->storeAs('categories', $imageName, 'public');
            }

            $item->update([
                'catename' => $request->catename,
                'slug' => $request->slug,
                'description' => $request->description,
                'image' => $imageName,
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

            $item = Category::findOrFail($id);

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

    /**
     * Display list of soft-deleted categories (trash)
     */
    public function trash($limit = 10)
    {
        $list = Category::onlyTrashed()
            ->select('cateid', 'catename', 'slug', 'description', 'image', 'status', 'deleted_at')
            ->orderBy('catename')
            ->paginate($limit);

        return view('admin.categories.trash', compact('list'));
    }

    /**
     * Restore all soft-deleted categories
     */
    public function restoreAll()
    {
        try {
            $items = Category::onlyTrashed()->get();
            if ($items->isEmpty()) {
                return redirect()->route('admin.categories.trash')->with('error', 'Không có mục nào để khôi phục.');
            }

            foreach ($items as $item) {
                $item->restore();
            }

            return redirect()->route('admin.categories.trash')->with('success', 'Khôi phục tất cả thành công.');
        } catch (\Exception $e) {
            Log::error('Category restoreAll failed: '.$e->getMessage());
            Log::error($e->getTraceAsString());
            return redirect()->back()->with('error', 'Khôi phục thất bại.');
        }
    }

    /**
     * Permanently delete all soft-deleted categories
     */
    public function forceDeleteAll()
    {
        try {
            $items = Category::onlyTrashed()->get();
            if ($items->isEmpty()) {
                return redirect()->route('admin.categories.trash')->with('error', 'Không có mục nào để xóa vĩnh viễn.');
            }

            foreach ($items as $item) {
                if ($item->image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete('categories/'.$item->image);
                }
                $item->forceDelete();
            }

            return redirect()->route('admin.categories.trash')->with('success', 'Xóa vĩnh viễn tất cả thành công.');
        } catch (\Exception $e) {
            Log::error('Category forceDeleteAll failed: '.$e->getMessage());
            Log::error($e->getTraceAsString());
            return redirect()->back()->with('error', 'Xóa vĩnh viễn thất bại.');
        }
    }

    /**
     * Restore a soft-deleted category
     */
    public function restore($id)
    {
        try {
            Category::onlyTrashed()->findOrFail($id)->restore();

            return redirect()
                ->route('admin.categories.trash')
                ->with('success', 'Khôi phục thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Thực hiện thất bại.');
        }
    }

    /**
     * Permanently delete a soft-deleted category
     */
    public function forceDelete($id)
    {
        try {
            $item = Category::onlyTrashed()->findOrFail($id);

            // delete stored image if exists
            if ($item->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('categories/'.$item->image);
            }

            $item->forceDelete();

            return redirect()
                ->route('admin.categories.trash')
                ->with('success', 'Xóa vĩnh viễn thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Thực hiện thất bại.');
        }
    }
}