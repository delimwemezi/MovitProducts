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
        'image',  // Cloudinary URL
    ];

    /**
     * Relationship: Product belongs to a Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get image URL - simple accessor for Cloudinary
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return $this->image;
        }
        return asset('images/no-image.png');
    }
}

