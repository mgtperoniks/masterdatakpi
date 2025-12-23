<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MdOperator;

class MdOperatorSeeder extends Seeder
{
    public function run(): void
    {
        $operators = [
            [
                'code' => 'OP-001',
                'name' => 'Operator A',
                'department_code' => 'BUBUT',
                'status' => 'active',
            ],
            [
                'code' => 'OP-002',
                'name' => 'Operator B',
                'department_code' => 'BUBUT',
                'status' => 'active',
            ],
        ];

        foreach ($operators as $op) {
            MdOperator::updateOrCreate(
                ['code' => $op['code']],
                $op
            );
        }
    }
}
