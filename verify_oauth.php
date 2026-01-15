<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "Starting verification...\n";

// 1. Create User
$email = 'checker_'.time().'@example.com';
$password = 'password123';

try {
    // Check if user exists (cleanup from failed runs)
    User::where('email', $email)->delete();

    $user = User::create([
        'name' => 'Checker',
        'email' => $email,
        'hashed_password' => Hash::make($password),
    ]);
    echo "[OK] User created: $email\n";
} catch (\Exception $e) {
    die("[FAIL] User creation failed: " . $e->getMessage() . "\n");
}

// 2. Simulate Login Logic
try {
    if (Hash::check($password, $user->hashed_password)) {
        echo "[OK] Password hash check passed.\n";
    } else {
        die("[FAIL] Password hash check failed.\n");
    }

    // Generate Token
    echo "Attempting to create token...\n";
    $tokenResult = $user->createToken('TestToken');
    $accessToken = $tokenResult->accessToken;

    if ($accessToken) {
        echo "[OK] OAuth Token Generated: " . substr($accessToken, 0, 20) . "...\n";
    } else {
        echo "[FAIL] Token generation returned null/empty.\n";
    }
    
    // Check DB
    $tokenInDb = \Illuminate\Support\Facades\DB::table('oauth_access_tokens')
        ->where('user_id', $user->id)
        ->where('revoked', 0)
        ->exists();
        
    if ($tokenInDb) {
        echo "[OK] Token found in database.\n";
    } else {
        echo "[FAIL] Token NOT found in database.\n";
    }

} catch (\Exception $e) {
    echo "[FAIL] Error during token generation: " . $e->getMessage() . "\n";
    // echo "Stack: " . $e->getTraceAsString() . "\n";
}

// Cleanup
try {
    if (isset($user)) {
        $user->tokens()->delete();
        $user->delete();
        echo "Cleanup done.\n";
    }
} catch (\Exception $e) {
    echo "Cleanup error: " . $e->getMessage();
}
