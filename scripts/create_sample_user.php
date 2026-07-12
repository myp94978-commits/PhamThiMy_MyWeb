<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'fullname' => 'Admin Test',
    'username' => 'admintest',
    'email' => 'admin@example.com',
    'password' => Hash::make('password123'),
    'phone' => '0123456789',
    'address' => 'Hanoi',
    'gender' => 1,
    'birthday' => '1990-01-01',
    'role' => 1,
    'status' => 1,
    'remember_token' => null,
]);

echo "Sample user created\n";
