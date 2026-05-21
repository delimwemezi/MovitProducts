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
        'image',        // ← stores path like "products/uuid.jpg"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Helper to get full image URL in any blade view
    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/no-image.png'); // fallback placeholder
    }
}

