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
                'department_code' => '100', // Temporarily disabled to fix FK violation
                'allowed_apps' => ['masterdata-kpi', 'kpi-bubut'],
            ],
            [
                'name' => 'MR',
                'email' => 'mr@peroniks.com',
                'role' => 'mr',
                'department_code' => '100.1', // Temporarily disabled to fix FK violation
                'allowed_apps' => ['masterdata-kpi', 'kpi-bubut'],
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
            // Ensure department exists if specified
            if (isset($u['department_code'])) {
                $deptCode = (string) $u['department_code'];

                // Try to find the department strictly
                $dept = \App\Models\MdDepartment::where('code', $deptCode)->first();

                if ($dept) {
                    // Start clean: use the EXACT code from the DB to avoid case/collation issues
                    $u['department_code'] = $dept->code;
                } else {
                    // Force Create if it doesn't exist
                    $this->command->warn("Department code $deptCode missing. Force creating now.");
                    $newDept = \App\Models\MdDepartment::create([
                        'code' => $deptCode,
                        'name' => 'Auto Created Dept ' . $deptCode,
                        'status' => 'active'
                    ]);
                    $u['department_code'] = $newDept->code;
                }
            }

            User::updateOrCreate(
                ['email' => $u['email']],
                array_merge($u, [
                    'password' => Hash::make('password123'),
                ])
            );
        }
    }
}
