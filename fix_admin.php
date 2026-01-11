<?php
// fix_admin.php
define('LARAVEL_START', microtime(true));
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$email = 'direktur@peroniks.com';
$user = User::where('email', $email)->first();

if ($user) {
    $user->department_code = '100';
    $user->role = 'direktur';
    $user->allowed_apps = ['masterdata-kpi', 'kpi-bubut'];
    $user->save();
    echo "SUCCESS_UPDATED\n";
} else {
    echo "USER_NOT_FOUND: $email\n";
}
