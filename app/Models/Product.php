<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'carton_price',
        'piece_price',
        'description',
        'category_id',
        'image',        // stores Cloudinary URL for backward compatibility
    ];

    /**
     * Relationship: Product belongs to a Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship: Product has many images (stored in MySQL)
     */
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the most recent/primary image
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->latest();
    }

    /**
     * Helper to get full image URL in any blade view
     * Prioritizes MySQL images, falls back to Cloudinary URLs
     */
    public function getImageUrlAttribute(): string
    {
        // Check if product has images stored in MySQL
        if ($this->primaryImage) {
            return route('product.image', $this->primaryImage->id);
        }

        // Fallback to existing Cloudinary URL
        if ($this->image) {
            return $this->image;
        }

        // Fallback to placeholder
        return asset('images/no-image.png');
    }
}
