<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->pluck('id')->all();

        $posts = [
            'Hướng dẫn Laravel Migration cơ bản',
            'Tạo Seeder và dữ liệu mẫu trong Laravel',
            'Quản lý User với Laravel CRUD',
            'Xây dựng bảng Brand và Category',
            'Thực hành tạo form trong Laravel',
            'Kết nối database MySQL với Laravel',
            'Laravel Route và Controller cơ bản',
            'Sử dụng Query Builder trong Laravel',
            'Tạo và quản lý blog bằng Laravel',
            'Giải thích cú pháp Eloquent ORM',
        ];

        foreach ($posts as $index => $title) {
            DB::table('posts')->insert([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . ($index + 1),
                'content' => 'Nội dung mẫu cho bài viết "' . $title . '".',
                'image' => 'post-' . ($index + 1) . '.jpg',
                'status' => 1,
                'user_id' => $users[array_rand($users)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
