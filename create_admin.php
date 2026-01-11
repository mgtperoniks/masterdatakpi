<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Create admin user in masterdataKPI
DB::connection('mysql')->table('users')->insertOrIgnore([
    'name' => 'Super Admin',
    'email' => 'admin@peroniks.com',
    'password' => Hash::make('password'),
    'role' => 'direktur',
    'scope' => 'ALL',
    'department_code' => null,
    'allowed_apps' => json_encode(['kpi-bubut', 'masterdata-kpi']),
    'created_at' => now(),
    'updated_at' => now(),
]);

echo "Admin user created successfully.\n";
