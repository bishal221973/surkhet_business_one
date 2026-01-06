<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\OrganizationSetting;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $org = Organization::create([
            'name' => 'Surkhet Business One',
            'address' => 'Surkhet, Banke, Nepal',
            'phone' => '+977-1234567890',
            'email' => 'surkhetbusinessone@example.com',
            'vat_number' => '1234567890',
            'activate_at' => now(),
        ]);
        app(\Spatie\Permission\PermissionRegistrar::class)
            ->setPermissionsTeamId($org->id);
        $role = Role::create([
            'name' => 's-admin',
            'guard_name' => 'web',
        ]);
        $user = User::create([
            'name' => 'Surkhet Business One',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'organization_id' => $org->id,
            'phone' => '0123456789'
        ]);


        $user->assignRole($role);

        OrganizationSetting::create([
            'key' => 'date_type',
            'value' => 'AD Date', //AD Date or BS Date
            'organization_id' => $org->id
        ]);
        OrganizationSetting::create([
            'key' => 'date_format',
            'value' => 'Y-m-d', //d-m-Y or m-d-Y or Y-m-d or d/m/Y or m/d/Y or Y/m/d
            'organization_id' => $org->id
        ]);

        OrganizationSetting::create([
            'key' => 'time_format',
            'value' => 'g:i A',
            // Possible time formats:
            // 12-hour formats:
            // 'g:i A'   => 1:30 PM
            // 'g:i a'   => 1:30 pm
            // 'h:i A'   => 01:30 PM
            // 'h:i a'   => 01:30 pm
            // 'g:i:s A' => 1:30:00 PM
            // 'g:i:s a' => 1:30:00 pm
            // 'h:i:s A' => 01:30:00 PM
            // 'h:i:s a' => 01:30:00 pm
            // 24-hour formats:
            // 'G:i'     => 13:30
            // 'H:i'     => 13:30
            // 'G:i:s'   => 13:30:00
            // 'H:i:s'   => 13:30:00
            'organization_id' => $org->id
        ]);

        OrganizationSetting::create([
            'key' => 'email_provider',
            'value' => 'smtp',
            'organization_id' => $org->id
        ]);
        OrganizationSetting::create([
            'key' => 'email_host',
            'value' => 'mailpit',
            'organization_id' => $org->id
        ]);
        OrganizationSetting::create([
            'key' => 'email_port',
            'value' => '1020',
            'organization_id' => $org->id
        ]);
        OrganizationSetting::create([
            'key' => 'email_username',
            'value' => 'demo@test.com',
            'organization_id' => $org->id
        ]);
        OrganizationSetting::create([
            'key' => 'email_password',
            'value' => 'password',
            'organization_id' => $org->id
        ]);
        OrganizationSetting::create([
            'key' => 'email_encryption',
            'value' => 'tls',
            'organization_id' => $org->id
        ]);
        OrganizationSetting::create([
            'key' => 'email_from_adress',
            'value' => 'demo@test.com',
            'organization_id' => $org->id
        ]);
        OrganizationSetting::create([
            'key' => 'email_from_name',
            'value' => 'App name',
            'organization_id' => $org->id
        ]);
    }
}
