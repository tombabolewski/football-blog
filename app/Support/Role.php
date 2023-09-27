<?php

declare(strict_types=1);

namespace App\Support;

use App\Support\Traits\EnhancedEnum;
use App\Support\Permission;

enum Role: string
{
    use EnhancedEnum;

    case ADMIN = 'admin';
    case JOURNALIST = 'journalist';
    case USER = 'user';

    public function getPermissions(): array
    {
        return match ($this) {
            static::JOURNALIST => [
                Permission::USER_LOGIN,
                Permission::POST_VIEW,
                Permission::POST_CREATE,
                Permission::POST_UPDATE,
                Permission::POST_DELETE,
            ],
            default => [],
        };
    }

    public function getPermissionsValues(): array
    {
        return collect($this->getPermissions())->pluck('value')->toArray();
    }

    public function getHumanReadableName(): string
    {
        return match ($this) {
            static::ADMIN => 'Administrator',
            static::JOURNALIST => 'Journalist',
            static::USER => 'Guest User',
        };
    }
}
