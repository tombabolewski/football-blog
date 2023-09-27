<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role as RoleModel;
use App\Support\Role;

class SyncRolesPermissions extends Command
{
    protected $signature = 'permission:sync';

    protected $description = 'Sync user roles with permissions';

    public function handle()
    {
        RoleModel::all()->each(
            function (RoleModel $roleModel) {
                if (!($role = Role::tryFrom($roleModel->name))) {
                    return;
                }
                $roleModel->syncPermissions($role->getPermissionsValues());
            }
        );
    }
}
