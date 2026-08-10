<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRequestItem extends Model
{
    protected $fillable = [
        'product_request_list_id',
        'product_id',
        'product_name',
        'cartons',
        'pieces',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'cartons' => 'integer',
        'pieces' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function productRequestList(): BelongsTo
    {
        return $this->belongsTo(ProductRequestList::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
