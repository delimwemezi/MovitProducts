<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessProfile extends Model
{
    protected $fillable = [
        'email',
        'location',
        'phone',
        'whatsapp_number',
    ];
}
