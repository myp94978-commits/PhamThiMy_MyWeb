<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['brandname' => 'Apple', 'image' => 'apple.png', 'status' => 1, 'sort_order' => 1, 'description' => 'Thương hiệu Apple nổi tiếng toàn cầu'],
            ['brandname' => 'Samsung', 'image' => 'samsung.png', 'status' => 1, 'sort_order' => 2, 'description' => 'Samsung với sản phẩm điện tử đa dạng'],
            ['brandname' => 'Xiaomi', 'image' => 'xiaomi.png', 'status' => 1, 'sort_order' => 3, 'description' => 'Xiaomi giá tốt, nhiều thiết bị thông minh'],
            ['brandname' => 'Nike', 'image' => 'nike.png', 'status' => 0, 'sort_order' => 4, 'description' => 'Thương hiệu thời trang thể thao Nike'],
            ['brandname' => 'Sony', 'image' => 'sony.png', 'status' => 1, 'sort_order' => 5, 'description' => 'Sony chuyên đồ công nghệ và giải trí'],
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->insert([
                'brandname' => $brand['brandname'],
                'slug' => Str::slug($brand['brandname']),
                'image' => $brand['image'],
                'status' => $brand['status'],
                'sort_order' => $brand['sort_order'],
                'description' => $brand['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
