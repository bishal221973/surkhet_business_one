<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UserSeeder::class);
        $this->call(OrganizationSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(FiscalYearSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(ExpenseHeadSeeder::class);
        $this->call(PaymentModeSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(MailFormatSeeder::class);
    }
}
