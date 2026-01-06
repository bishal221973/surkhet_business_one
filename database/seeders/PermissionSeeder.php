<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions=[
            'show.totalclient',
            'show.totalincome',
            'show.totalexpense',
            'show.totaldues',
            'visitor.create',
            'visitor.read',
            'visitor.edit',
            'visitor.delete',
            'calllog.create',
            'calllog.read',
            'calllog.edit',
            'calllog.delete',
            'postal.dispatch.create',
            'postal.dispatch.read',
            'postal.dispatch.edit',
            'postal.dispatch.delete',
            'postal.receive.create',
            'postal.receive.read',
            'postal.receive.edit',
            'postal.receive.delete',
            'complain.create',
            'complain.read',
            'complain.edit',
            'complain.delete',
            'employee.create',
            'employee.read',
            'employee.edit',
            'employee.delete',
            'role.create',
            'role.read',
            'role.edit',
            'role.delete',
            'organization.setting',
            'email.setting',
            'assign.permission',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions($permissions);

        $sAdmin = Role::firstOrCreate(['name' => 's-admin', 'guard_name' => 'web']);
        $sAdmin->syncPermissions($permissions);

        $this->command->info('Permissions and roles seeded successfully!');
    }
}
