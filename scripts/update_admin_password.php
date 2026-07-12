<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('username', 'admin')->first();
if (!$user) {
    echo "admin user not found\n";
    exit(1);
}

$duplicate = User::where('email', 'admin@example.com')
    ->where('username', '!=', 'admin')
    ->first();
if ($duplicate) {
    $duplicate->email = 'admintest@example.com';
    $duplicate->save();
    echo "Updated duplicate email for user {$duplicate->username} to admintest@example.com\n";
}

$user->password = Hash::make('password123');
$user->email = 'admin@example.com';
$user->save();

echo "Admin password reset to password123 and email set to admin@example.com\n";
