<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MdDepartment;

class MdDepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['code' => 'BUBUT', 'name' => 'Bubut', 'status' => 'active'],
            ['code' => 'COR', 'name' => 'Cor', 'status' => 'active'],
            ['code' => 'GUDANG', 'name' => 'Gudang', 'status' => 'active'],
            ['code' => 'QA', 'name' => 'Quality Assurance', 'status' => 'active'],
            // Management Codes for Direktur & MR
            ['code' => '100', 'name' => 'Direksi', 'status' => 'active'],
            ['code' => '100.1', 'name' => 'Management Rep', 'status' => 'active'],
        ];

        foreach ($departments as $dept) {
            MdDepartment::updateOrCreate(
                ['code' => $dept['code']],
                $dept
            );
        }
    }
}
