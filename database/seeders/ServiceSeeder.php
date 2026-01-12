<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'organization_id' => 1,
                'unit_id' => 1,
                'name' => 'Service 1',
                'rate' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'organization_id' => 1,
                'unit_id' => 3,
                'name' => 'Service 2',
                'rate' => 400,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'organization_id' => 1,
                'unit_id' => 2,
                'name' => 'Service 3',
                'rate' => 1000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'organization_id' => 1,
                'unit_id' => 2,
                'name' => 'Service 4',
                'rate' => 500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'organization_id' => 1,
                'unit_id' => 3,
                'name' => 'Service 5',
                'rate' => 1200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
