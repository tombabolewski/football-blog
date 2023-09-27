<?php

declare(strict_types=1);

namespace App\Support;

use App\Support\Traits\EnhancedEnum;

enum Permission: string
{
    use EnhancedEnum;

    case USER_LOGIN = 'user.login';
    case USER_VIEW_ANY = 'user.viewAny';
    case USER_VIEW = 'user.view';
    case USER_CREATE = 'user.create';
    case USER_UPDATE = 'user.update';
    case USER_DELETE = 'user.delete';

    case POST_VIEW = 'post.view';
    case POST_CREATE = 'post.create';
    case POST_UPDATE = 'post.update';
    case POST_DELETE = 'post.delete';
}
