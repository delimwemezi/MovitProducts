<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductRequestList extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'whatsapp_number',
        'location',
        'notes',
        'total_amount',
        'status',
        'admin_reply',
        'reviewed_at',
        'replied_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'reviewed_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProductRequestItem::class);
    }
}
