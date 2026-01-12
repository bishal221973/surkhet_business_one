<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banks')->insert([
            [
                'organization_id' => 1,
                'name' => 'Nepal Bank',
                'balance' => 12500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'organization_id' => 1,
                'name' => 'Counter',
                'balance' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'organization_id' => 1,
                'name' => 'Esewa',
                'balance' => 8500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
