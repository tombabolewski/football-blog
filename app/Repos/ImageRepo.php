<?php

declare(strict_types=1);

namespace App\Repos;

use App\Models\Image;

class ImageRepo extends BaseRepo
{
    protected static readonly string $modelClass = Image::class;
}
