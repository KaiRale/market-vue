<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function destroy(Image $image)
    {
        ImageService::destroy($image);

        return back()->with([
            'success' => 'Image deleted',
            'deleted_image_id' => $image->id
        ]);
    }
}
