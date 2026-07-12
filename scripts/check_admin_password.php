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

echo "username={$user->username} email={$user->email} password_hash={$user->password}\n";

foreach (['password123', 'newpassword123', 'admin123', '12345678'] as $pass) {
    echo "check {$pass}: " . (Hash::check($pass, $user->password) ? 'true' : 'false') . "\n";
}
