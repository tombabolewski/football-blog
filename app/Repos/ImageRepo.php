<?php

namespace App\Repos;

use App\Models\Image;

class ImageRepo extends BaseRepo
{
    protected static string $modelClass = Image::class;
}
