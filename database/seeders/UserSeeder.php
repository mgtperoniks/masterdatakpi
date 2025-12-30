<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Direktur',
                'email' => 'direktur@peroniks.com',
                'role' => 'direktur',
                'scope' => 'ALL',
            ],
            [
                'name' => 'MR',
                'email' => 'mr@peroniks.com',
                'role' => 'MR',
                'scope' => 'ALL',
            ],
            [
                'name' => 'Manager PPIC',
                'email' => 'managerppic@peroniks.com',
                'role' => 'manager',
                'scope' => 'PPIC',
            ],
            [
                'name' => 'Manager HR',
                'email' => 'managerhr@peroniks.com',
                'role' => 'manager',
                'scope' => 'HR',
            ],
            [
                'name' => 'Admin PPIC',
                'email' => 'adminppicflange@peroniks.com',
                'role' => 'admin',
                'scope' => 'PPIC',
            ],
            [
                'name' => 'Admin HR',
                'email' => 'adminhr@peroniks.com',
                'role' => 'admin',
                'scope' => 'HR',
            ],
            [
                'name' => 'Auditor',
                'email' => 'auditor@peroniks.com',
                'role' => 'auditor',
                'scope' => 'ALL',
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                array_merge($u, [
                    'password' => Hash::make('password123'),
                ])
            );
        }
    }
}
