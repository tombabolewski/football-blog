<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\InternalServerErrorHttpException;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Repos\ImageRepo;
use Illuminate\Support\Facades\Storage;

/**
 * @see \App\Http\Controllers\Web\ImageController for store and show actions
 */
class ImageController extends Controller
{
    public function __construct(private ImageRepo $imageRepo)
    {
        $this->authorizeResource(Image::class, 'image');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        $isDeleted = $this->imageRepo->delete($image) && Storage::delete($image->path);
        if ($isDeleted === false) {
            throw new InternalServerErrorHttpException('Unable to delete image');
        }
        return response()->json(['message' => 'Image deleted successfully']);
    }
}
