<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_data',
        'mime_type',
        'original_filename',
        'file_size',
        'is_cloudinary',
        'cloudinary_url',
    ];

    /**
     * Relationship: Image belongs to a Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the data URL for displaying in img src
     * Returns base64 encoded image data
     */
    public function getDataUrlAttribute(): string
    {
        $imageData = $this->image_data;
        if (is_resource($imageData)) {
            $imageData = stream_get_contents($imageData);
        }
        $base64 = base64_encode($imageData);
        return "data:{$this->mime_type};base64,{$base64}";
    }
}
