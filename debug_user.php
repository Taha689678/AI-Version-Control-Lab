<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$email = 'maliktaha983@gmail.com';
$user = User::where('email', $email)->first();

if ($user) {
    echo "User Found:\n";
    echo "ID: " . $user->id . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Role: " . $user->role . "\n";
    echo "Email Verified At: " . ($user->email_verified_at ?? 'NULL') . "\n";
    echo "Verification Code: " . ($user->verification_code ?? 'NULL') . "\n";
    echo "Expires At: " . ($user->verification_code_expires_at ?? 'NULL') . "\n";
    echo "Current Time: " . now() . "\n";
} else {
    echo "User $email not found.\n";
}
