<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'organization_id' => 1,
                'name' => 'Ram Prasad Shrestha',
                'type' => 'Customer',
                'email' => 'ram.shrestha@example.com',
                'phone' => '9841234567',
                'address' => 'Kathmandu Metropolitan City-10, New Baneshwor',
                'vat_number' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'organization_id' => 1,
                'name' => 'Shiva Shakti Traders',
                'type' => 'Company',
                'email' => 'shivashakti@example.com',
                'phone' => '9812345678',
                'address' => 'Pokhara Metropolitan City-8, Chipledhunga',
                'vat_number' => '302456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'organization_id' => 1,
                'name' => 'Sita Kumari Adhikari',
                'type' => 'Customer',
                'email' => 'sita.adhikari@example.com',
                'phone' => '9860123456',
                'address' => 'Bharatpur Metropolitan City-5, Chitwan',
                'vat_number' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'organization_id' => 1,
                'name' => 'Himalayan Suppliers Pvt. Ltd.',
                'type' => 'Company',
                'email' => 'himalayan.suppliers@example.com',
                'phone' => '9801122334',
                'address' => 'Lalitpur Metropolitan City-3, Pulchowk',
                'vat_number' => '401234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('clients')->insert($clients);
    }
}
