<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
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
                'status' => 'required|in:0,1',
            ],
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'max' => ':attribute không vượt quá :max ký tự.',
                'unique' => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'status.in' => ':attribute không hợp lệ.',
            ],
            [
                'catename' => 'Tên loại',
                'slug' => 'Đường dẫn (Slug)',
                'description' => 'Mô tả',
                'status' => 'Trạng thái',
            ]
        );

        try {

            Category::create([
                'catename' => $request->catename,
                'slug' => $request->slug,
                'description' => $request->description,
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

                'status' => 'required|in:0,1',
            ],
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'max' => ':attribute không vượt quá :max ký tự.',
                'unique' => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'status.in' => ':attribute không hợp lệ.',
            ],
            [
                'catename' => 'Tên loại',
                'slug' => 'Đường dẫn (Slug)',
                'description' => 'Mô tả',
                'status' => 'Trạng thái',
            ]
        );

        try {

            $item = Category::findOrFail($id);

            $item->update([
                'catename' => $request->catename,
                'slug' => $request->slug,
                'description' => $request->description,
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
}