<?php

namespace Database\Seeders;

use App\Models\Fiscalyear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FiscalYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fiscalyear::create([
            'name' => '2082-2083',
            'start_date' => '2082-04-01',
            'end_date' => '2083-03-30',
            'is_active' => true,
            'created_by' => 1,
            'organization_id' => 1,
        ]);
    }
}
