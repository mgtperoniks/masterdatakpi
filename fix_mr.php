<?php
// fix_mr.php
define('LARAVEL_START', microtime(true));
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'mr@peroniks.com';
$user = User::where('email', $email)->first();

if ($user) {
    $user->department_code = '100.1';
    $user->role = 'mr';
    $user->allowed_apps = ['masterdata-kpi', 'kpi-bubut'];
    $user->save();
    echo "SUCCESS_UPDATED_MR\n";
} else {
    User::create([
        'name' => 'Management Representative',
        'email' => $email,
        'password' => Hash::make('password123'),
        'department_code' => '100.1',
        'role' => 'mr',
        'allowed_apps' => ['masterdata-kpi', 'kpi-bubut']
    ]);
    echo "SUCCESS_CREATED_MR\n";
}
