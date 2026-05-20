<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
$user = User::where('email', 'maliktaha983@gmail.com')->first();
if ($user) {
    echo "CODE: " . ($user->verification_code ?? 'NULL') . "\n";
    echo "EXPIRES: " . ($user->verification_code_expires_at ?? 'NULL') . "\n";
} else {
    echo "User not found\n";
}
