<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MdDepartmentSeeder;
use Database\Seeders\MdLineSeeder;
use Database\Seeders\MdMachineSeeder;
use Database\Seeders\MdOperatorSeeder;
use Database\Seeders\MdItemSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        $this->call([
            MdDepartmentSeeder::class,
            MdLineSeeder::class,
            MdMachineSeeder::class,
            MdOperatorSeeder::class,
            MdItemSeeder::class,
            UserSeeder::class,
        ]);

        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
    }
}
