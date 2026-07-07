<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');
        $id = null;

        if ($product instanceof \App\Models\Product) {
            $id = $product->id;
        } elseif (is_numeric($product)) {
            $id = $product;
        }

        return [
            'productname' => [
                'required',
                'string',
                'min:5',
                'max:150',
                Rule::unique('products', 'productname')->ignore($id, 'id'),
            ],
            'slug' => [
                'required',
                'string',
                'min:5',
                'max:200',
                'regex:/^[a-zA-Z0-9_-]+$/',
                Rule::unique('products', 'slug')->ignore($id, 'id'),
            ],
            'cateid' => ['required', 'exists:categories,cateid'],
            'brandid' => ['required', 'exists:brands,id'],
            'price' => ['required', 'numeric', 'min:0', 'max:10000000'],
            'pricediscount' => ['nullable', 'numeric', 'min:0', 'lte:price'],
            'status' => ['required', 'in:0,1'],
            'img' => $this->isMethod('post') ? ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:200'] : ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:200'],
            'imgs' => ['nullable', 'array'],
            'imgs.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:200'],
            'description' => ['nullable', 'string', 'not_regex:/[@!$^]/'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute là bắt buộc.',
            'min' => ':attribute phải có ít nhất :min ký tự.',
            'max' => ':attribute không được vượt quá :max ký tự.',
            'numeric' => ':attribute phải là số.',
            'in' => ':attribute không hợp lệ.',
            'exists' => ':attribute không tồn tại.',
            'unique' => ':attribute đã tồn tại.',
            'slug.regex' => ':attribute chỉ được chứa chữ, số, dấu gạch dưới (_) và dấu gạch ngang (-).',
            'img.image' => ':attribute phải là hình ảnh.',
            'img.mimes' => ':attribute chỉ chấp nhận các định dạng: jpg, jpeg, png, webp.',
            'img.max' => ':attribute không được vượt quá 200 KB.',
            'imgs.*.image' => ':attribute phải là hình ảnh.',
            'imgs.*.mimes' => ':attribute chỉ chấp nhận các định dạng: jpg, jpeg, png, webp.',
            'imgs.*.max' => ':attribute không được vượt quá 200 KB.',
            'description.not_regex' => ':attribute không được chứa ký tự đặc biệt @, !, $ hoặc ^.',
            'pricediscount.lte' => ':attribute phải nhỏ hơn hoặc bằng Giá.',
            'price.max' => ':attribute phải nhỏ hơn hoặc bằng 10.000.000.',
        ];
    }

    public function attributes(): array
    {
        return [
            'productname' => 'Tên sản phẩm',
            'slug' => 'Slug',
            'cateid' => 'Loại sản phẩm',
            'brandid' => 'Thương hiệu',
            'price' => 'Giá',
            'pricediscount' => 'Giá khuyến mãi',
            'status' => 'Trạng thái',
            'img' => 'Ảnh chính',
            'imgs' => 'Ảnh phụ',
            'description' => 'Mô tả',
        ];
    }
}
