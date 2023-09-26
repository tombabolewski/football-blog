<?php

declare(strict_types=1);

namespace App\Support;

enum Role: string
{
    case ADMIN = 'admin';
    case JOURNALIST = 'journalist';
    case USER = 'user';

    public function getPermissions(): array
    {
        return match($this) {
            static::JOURNALIST => [
                Permissions::USER_LOGIN,
                Permissions::POST_VIEW,
                Permissions::POST_CREATE,
                Permissions::POST_UPDATE,
                Permissions::POST_DELETE,
            ],
            default => [],
        };
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
