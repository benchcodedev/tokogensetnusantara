<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function current(): self
    {
        $setting = static::first();
        if ($setting) {
            return $setting;
        }

        return static::create([
            'site_name' => 'Abadi Jaya Furniture',
            'tagline' => 'Kontraktor Interior & Custom Furniture Luxury',
            'instagram' => '@abadijaya.id',
            'instagram_url' => 'https://instagram.com/abadijaya.id',
            'whatsapp_number' => '6283872500925',
            'phone_number' => '+62 838-7250-0925',
            'email' => 'info@abadijaya.id',
            'office_address' => 'Pondok Indah Mall 1, Lantai GF No. 017 & 022, Jakarta Selatan',
            'footer_text' => 'Kontraktor interior dan workshop furniture custom mewah berbasis di Jakarta. Menghadirkan presisi arsitektural dan material kelas dunia.',
            'meta_title' => 'Abadi Jaya Furniture — Kontraktor Interior & Furniture Custom Luxury Jakarta',
            'meta_description' => 'Wujudkan interior impian dan furniture custom bergaya luxury di Jakarta bersama Abadi Jaya Furniture. Spesialis wallpanel, master bedroom, apartemen, dan kantor.',
            'hero_video_url' => 'https://www.youtube.com/embed/ScMzIvxBSi4',
        ]);
    }
}
