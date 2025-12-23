<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MdItem;

class MdItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'code' => 'ITEM-BB-001',
                'name' => 'Flange 2 Inch',
                'department_code' => 'BUBUT',
                'cycle_time_sec' => 600,
                'status' => 'active',
            ],
            [
                'code' => 'ITEM-BB-002',
                'name' => 'Flange 3 Inch',
                'department_code' => 'BUBUT',
                'cycle_time_sec' => 720,
                'status' => 'active',
            ],
        ];

        foreach ($items as $item) {
            MdItem::updateOrCreate(
                ['code' => $item['code']],
                $item
            );
        }
    }
}
