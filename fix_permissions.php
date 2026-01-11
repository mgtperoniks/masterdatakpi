<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Ensure an admin user exists with Dept 100 to access User Management
$email = 'direktur@peroniks.com';
$user = User::where('email', $email)->first();

if ($user) {
    $user->update([
        'department_code' => '100',
        'role' => 'direktur',
        'allowed_apps' => ['masterdata-kpi', 'kpi-bubut']
    ]);
    echo "User $email updated to Dept 100 (Director).\n";
} else {
    User::create([
        'name' => 'Direktur Utama',
        'email' => $email,
        'password' => Hash::make('password123'),
        'department_code' => '100',
        'role' => 'direktur',
        'allowed_apps' => ['masterdata-kpi', 'kpi-bubut']
    ]);
    echo "User $email created as Dept 100 (Director) with password 'password123'.\n";
}
