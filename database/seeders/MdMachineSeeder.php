<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MdMachine;

class MdMachineSeeder extends Seeder
{
    public function run(): void
    {
        $machines = [
            [
                'code' => 'MC-BB-01',
                'name' => 'Mesin Bubut CNC 01',
                'department_code' => 'BUBUT',
                'line_code' => 'BUBUT-1',
                'status' => 'active',
            ],
            [
                'code' => 'MC-BB-02',
                'name' => 'Mesin Bubut CNC 02',
                'department_code' => 'BUBUT',
                'line_code' => 'BUBUT-2',
                'status' => 'maintenance',
            ],
        ];

        foreach ($machines as $machine) {
            MdMachine::updateOrCreate(
                ['code' => $machine['code']],
                $machine
            );
        }
    }
}
