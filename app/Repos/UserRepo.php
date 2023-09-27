<?php

namespace App\Repos;

use App\Events\UserCreatedEvent;
use App\Events\UserRoleChangedEvent;
use App\Exceptions\InvalidRoleException;
use App\Models\User;
use App\Support\Role;
use Illuminate\Database\Eloquent\Model;

class UserRepo extends BaseRepo
{
    protected static string $modelClass = User::class;

    protected function afterCreate($user): void
    {
        parent::afterCreate($user);
        $user->syncRoles(Role::USER->value);
        event(new UserCreatedEvent($user));
    }

    protected function beforeUpdate($user, array $properties): void
    {
        parent::beforeUpdate($user, $properties);
        if (isset($properties['role'])) {
            if (!($role = Role::tryFrom($properties['role']))) {
                throw new InvalidRoleException();
            }
            $oldRole = Role::from($user->roles->first());
            $user->syncRoles($role->value);
            unset($properties['role']);
            event(new UserRoleChangedEvent($user, $oldRole, $role));
        }
    }
}
