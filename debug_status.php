<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$email = 'maliktaha983@gmail.com';
$user = User::where('email', $email)->first();

if ($user) {
    echo "ID: " . $user->id . "\n";
    echo "Role: " . $user->role . "\n";
    echo "Verified At: " . ($user->email_verified_at ?? 'NULL') . "\n";
} else {
    echo "User not found\n";
}
