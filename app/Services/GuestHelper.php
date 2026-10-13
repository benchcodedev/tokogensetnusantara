<?php

namespace App\Services;

use App\Models\Guest;
use Illuminate\Support\Str;

class GuestHelper
{
    /**
     * Normalisasi nomor HP ke format 62xxx
     * Buang spasi, tanda +, tanda -, dan angka 0 di depan
     */
    public static function normalizePhoneNumber(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }

        // Ambil hanya digit
        $digits = preg_replace('/\D+/', '', $phone);

        if (empty($digits)) {
            return null;
        }

        // Jika diawali 08xxx -> ubah jadi 628xxx
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }
        // Jika diawali 8xxx -> ubah jadi 628xxx
        elseif (str_starts_with($digits, '8')) {
            $digits = '62' . $digits;
        }

        return $digits;
    }

    /**
     * Generate slug unik acak 8-12 karakter (default 10 karakter tidak bisa ditebak)
     */
    public static function generateUniqueSlug(int $length = 10): string
    {
        do {
            // Kombinasi huruf kecil dan angka acak agar mudah dan aman di URL
            $slug = strtolower(Str::random($length));
        } while (Guest::where('slug_unik', $slug)->exists());

        return $slug;
    }

    /**
     * Parse nilai Pax: ambil angka dari teks (misal "2 orang" -> 2)
     * Return null jika tidak ada angka yang terbaca atau angka < 1
     */
    public static function parsePax($value): ?int
    {
        if (is_null($value) || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            $int = (int) $value;
            return $int >= 1 ? $int : null;
        }

        if (preg_match('/(\d+)/', (string) $value, $matches)) {
            $int = (int) $matches[1];
            return $int >= 1 ? $int : null;
        }

        return null;
    }
}
