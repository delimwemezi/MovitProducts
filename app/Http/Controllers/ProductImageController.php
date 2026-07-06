<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Response;

class ProductImageController extends Controller
{
    /**
     * Serve product image from database
     * 
     * @param int $imageId
     * @return Response
     */
    public function show($imageId)
    {
        $image = ProductImage::findOrFail($imageId);

        return response($image->image_data, 200, [
            'Content-Type'        => $image->mime_type,
            'Content-Length'      => $image->file_size,
            'Cache-Control'       => 'public, max-age=604800', // Cache for 1 week
            'Content-Disposition' => 'inline; filename="' . $image->original_filename . '"',
        ]);
    }
}
