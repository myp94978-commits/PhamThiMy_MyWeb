<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('users')->insert([
    [
        'fullname' => 'Nguyễn Văn An',
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'phone' => '0123456789',
        'address' => 'Hà Nội',
        'gender' => 1,
        'birthday' => '1990-01-01',
        'role' => 1,
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'fullname' => 'Trần Thị Bình',
        'username' => 'staff1',
        'email' => 'staff1@example.com',
        'password' => bcrypt('password'),
        'phone' => '0987654321',
        'address' => 'Hồ Chí Minh',
        'gender' => 2,
        'birthday' => '1992-05-10',
        'role' => 2,
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]]);
    }
}
