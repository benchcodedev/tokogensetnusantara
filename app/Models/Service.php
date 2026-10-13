<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'gallery_images' => 'array',
        'benefits' => 'array',
        'is_featured' => 'boolean',
    ];
}
