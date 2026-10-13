<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'foto',
        'caption',
        'tipe',
        'urutan',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->foto)) {
            return null;
        }

        if (str_starts_with($this->foto, 'http')) {
            return $this->foto;
        }

        if (str_starts_with($this->foto, 'storage/') || str_starts_with($this->foto, '/storage/')) {
            return asset(ltrim($this->foto, '/'));
        }

        $publicPath = public_path(ltrim($this->foto, '/'));
        if (file_exists($publicPath)) {
            return asset(ltrim($this->foto, '/'));
        }

        return null;
    }
}
