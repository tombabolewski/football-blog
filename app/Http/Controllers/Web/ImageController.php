<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Repos\ImageRepo;
use App\Models\Image;

class ImageController extends Controller
{
    public function __construct(private ImageRepo $imageRepo)
    {
        $this->authorizeResource(Image::class, 'image');
    }

    public function show(Image $image)
    {
        return response()->file($image->storage_path, ['Content-Type' => $image->mime_type]);
    }
}
