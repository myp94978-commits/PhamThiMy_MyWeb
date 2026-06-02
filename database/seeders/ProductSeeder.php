<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = DB::table('categories')->pluck('cateid')->all();
        $brands = DB::table('brands')->pluck('id')->all();

        $products = [
            ['Tên sản phẩm' => 'Điện thoại iPhone 14', 'price' => 23000000],
            ['Tên sản phẩm' => 'Laptop MacBook Air', 'price' => 32000000],
            ['Tên sản phẩm' => 'Tai nghe AirPods Pro', 'price' => 6500000],
            ['Tên sản phẩm' => 'Laptop Dell Inspiron', 'price' => 18000000],
            ['Tên sản phẩm' => 'Điện thoại Samsung Galaxy', 'price' => 21000000],
            ['Tên sản phẩm' => 'Balo thời trang', 'price' => 650000],
            ['Tên sản phẩm' => 'Máy giặt LG', 'price' => 14000000],
            ['Tên sản phẩm' => 'Tivi Sony 55 inch', 'price' => 22000000],
            ['Tên sản phẩm' => 'Chuột không dây', 'price' => 450000],
            ['Tên sản phẩm' => 'Bàn phím cơ', 'price' => 1200000],
        ];

        foreach ($products as $index => $item) {
            DB::table('products')->insert([
                'productname' => $item['Tên sản phẩm'],
                'slug' => Str::slug($item['Tên sản phẩm']) . '-' . ($index + 1),
                'price' => $item['price'],
                'pricediscount' => rand(0, 500000),
                'image' => 'product-' . ($index + 1) . '.jpg',
                'description' => 'Mô tả cho ' . $item['Tên sản phẩm'] . '. Sản phẩm chất lượng, phù hợp nhu cầu.',
                'status' => 1,
                'brandid' => $brands[array_rand($brands)],
                'cateid' => $categories[array_rand($categories)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
