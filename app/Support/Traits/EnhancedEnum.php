<?php

declare(strict_types=1);

namespace App\Support\Traits;

trait EnhancedEnum
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::names(), self::values());
    }
}
