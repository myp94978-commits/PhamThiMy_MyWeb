<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('username', 'admin')->first();
if ($user) {
    echo "User 'admin' already exists\n";
    exit(0);
}

User::create([
    'fullname' => 'Admin User',
    'username' => 'admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password123'),
    'phone' => '0987654321',
    'address' => 'Hanoi',
    'gender' => 1,
    'birthday' => '1990-01-01',
    'role' => 1,
    'status' => 1,
    'remember_token' => null,
]);

echo "Admin user created: username=admin password=password123\n";
