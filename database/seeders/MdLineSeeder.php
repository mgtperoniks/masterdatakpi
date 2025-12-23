<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MdLine;

class MdLineSeeder extends Seeder
{
    public function run(): void
    {
        $lines = [
            ['code' => 'BUBUT-1', 'department_code' => 'BUBUT', 'name' => 'Bubut Line 1', 'status' => 'active'],
            ['code' => 'BUBUT-2', 'department_code' => 'BUBUT', 'name' => 'Bubut Line 2', 'status' => 'active'],
        ];

        foreach ($lines as $line) {
            MdLine::updateOrCreate(
                ['code' => $line['code']],
                $line
            );
        }
    }
}
