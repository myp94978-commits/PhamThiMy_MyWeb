<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('username', 'admin')->orWhere('email', 'admin@example.com')->first();
if (! $user) {
    echo "Admin user not found\n";
    exit(1);
}

$user->password = Hash::make('password123');
$user->save();

echo "Admin password reset to: password123\n";
