<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
{
    /**
     * Xác định người dùng có quyền gửi Request hay không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Rules Validation
     */
    public function rules(): array
{
    // Lấy id từ URL khi update
    $id = $this->route('brand');

    if ($id instanceof \App\Models\Brand) {
        $id = $id->id;
    }

    return [

            'brandname' => [
                'required',
                'min:3',
                'max:50',
                Rule::unique('brands', 'brandname')->ignore($id, 'id'),
            ],

            'slug' => [
                'nullable',
                'min:3',
                'max:80',
                Rule::unique('brands', 'slug')->ignore($id, 'id'),
                'regex:/^[a-z0-9-]+$/',
            ],

            'description' => 'nullable|max:500',

            'status' => 'required|in:0,1',

        ];
    }

    /**
     * Nội dung thông báo lỗi
     */
    public function messages(): array
    {
        return [

            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'status.in' => ':attribute không hợp lệ.',

        ];
    }

    /**
     * Tên hiển thị các trường
     */
    public function attributes(): array
    {
        return [

            'brandname' => 'Tên thương hiệu',
            'slug' => 'Đường dẫn (Slug)',
            'description' => 'Mô tả',
            'status' => 'Trạng thái',

        ];
    }
}

