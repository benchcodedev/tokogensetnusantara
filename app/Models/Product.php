<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'kategori',
        'brand',
        'kapasitas_kva',
        'kapasitas_label',
        'tipe',
        'deskripsi',
        'spesifikasi',
        'foto_utama',
        'galeri',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'spesifikasi' => 'array',
        'galeri' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'kapasitas_kva' => 'float',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->nama);
            }
        });
    }

    /**
     * Get WhatsApp click-to-chat inquiry link with auto-filled message
     */
    public function getWhatsappInquiryUrl(): string
    {
        $phone = Setting::get('whatsapp_number', '6282142458076');
        $phoneClean = preg_replace('/[^0-9]/', '', $phone);
        
        $message = "Halo Toko Genset Nusantara, saya ingin tanya harga untuk unit: {$this->nama}";
        if ($this->brand) {
            $message .= " (Brand: {$this->brand})";
        }
        if ($this->kapasitas_label) {
            $message .= " - Kapasitas {$this->kapasitas_label}";
        }
        $message .= ". Mohon info ketersediaan dan penawaran harganya. Terima kasih.";

        return "https://wa.me/{$phoneClean}?text=" . rawurlencode($message);
    }

    /**
     * Get primary image URL or check if file exists in public/images
     */
    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->foto_utama)) {
            return null;
        }

        // Check if starts with http or /
        if (str_starts_with($this->foto_utama, 'http')) {
            return $this->foto_utama;
        }

        // Check if stored in storage
        if (str_starts_with($this->foto_utama, 'storage/') || str_starts_with($this->foto_utama, '/storage/')) {
            return asset(ltrim($this->foto_utama, '/'));
        }

        // If file exists in public/images/
        $publicPath = public_path(ltrim($this->foto_utama, '/'));
        if (file_exists($publicPath)) {
            return asset(ltrim($this->foto_utama, '/'));
        }

        return null;
    }
}
