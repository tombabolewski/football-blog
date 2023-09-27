<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\PermissionRegistrar;
use App\Support\Permission;
use App\Support\Role;
use Spatie\Permission\Models\Permission as PermissionModel;
use Spatie\Permission\Models\Role as RoleModel;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $this->forgetCachedPermissions();

        // Create permissions
        foreach (Permission::values() as $permission) {
            PermissionModel::create(['name' => $permission]);
        }

        // Create roles
        foreach (Role::values() as $role) {
            RoleModel::create(['name' => $role]);
        }

        // Sync roles with permissions
        Artisan::call('permission:sync');
    }

    protected function forgetCachedPermissions(): void
    {
        // Reset cached roles and permissions
        /** @var PermissionRegistrar $permissionRegistrar */
        $permissionRegistrar = app()[PermissionRegistrar::class];
        $permissionRegistrar->forgetCachedPermissions();
    }
}
