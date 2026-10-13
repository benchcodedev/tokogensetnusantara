<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Store and optimize an uploaded image to WebP, generating thumbnail as well.
     */
    public static function uploadAndConvert(UploadedFile $file, string $directory = 'products', int $quality = 85): array
    {
        $filename = Str::random(24);
        $disk = Storage::disk('public');
        
        // Ensure directory exists
        if (!$disk->exists($directory)) {
            $disk->makeDirectory($directory);
        }
        if (!$disk->exists("{$directory}/thumbs")) {
            $disk->makeDirectory("{$directory}/thumbs");
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $tempPath = $file->getRealPath();

        // If GD is available and file is jpeg/png/webp
        $webpPath = "{$directory}/{$filename}.webp";
        $thumbPath = "{$directory}/thumbs/{$filename}.webp";
        $fullStoragePath = storage_path("app/public/{$webpPath}");
        $fullThumbPath = storage_path("app/public/{$thumbPath}");

        if (function_exists('imagecreatefromstring')) {
            $imageData = file_get_contents($tempPath);
            $source = @imagecreatefromstring($imageData);

            if ($source) {
                // Ensure truecolor & alpha
                imagepalettetotruecolor($source);
                imagealphablending($source, true);
                imagesavealpha($source, true);

                $width = imagesx($source);
                $height = imagesy($source);

                // Save main WebP
                @imagewebp($source, $fullStoragePath, $quality);

                // Create thumbnail (max 400x400)
                $maxThumb = 400;
                $thumbWidth = $width;
                $thumbHeight = $height;
                if ($width > $maxThumb || $height > $maxThumb) {
                    $ratio = min($maxThumb / $width, $maxThumb / $height);
                    $thumbWidth = (int) round($width * $ratio);
                    $thumbHeight = (int) round($height * $ratio);
                }

                $thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);
                imagealphablending($thumbImg, false);
                imagesavealpha($thumbImg, true);
                $transparent = imagecolorallocatealpha($thumbImg, 255, 255, 255, 127);
                imagefilledrectangle($thumbImg, 0, 0, $thumbWidth, $thumbHeight, $transparent);
                imagecopyresampled($thumbImg, $source, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

                @imagewebp($thumbImg, $fullThumbPath, 80);
                imagedestroy($thumbImg);
                imagedestroy($source);

                return [
                    'path' => $webpPath,
                    'thumb' => $thumbPath,
                    'url' => asset("storage/{$webpPath}"),
                    'thumb_url' => asset("storage/{$thumbPath}"),
                ];
            }
        }

        // Fallback: normal storage
        $stored = $file->storeAs($directory, "{$filename}.{$extension}", 'public');
        return [
            'path' => $stored,
            'thumb' => $stored,
            'url' => asset("storage/{$stored}"),
            'thumb_url' => asset("storage/{$stored}"),
        ];
    }

    /**
     * Convert an existing file to WebP
     */
    public static function convertToWebP(string $sourcePath, int $quality = 85): ?string
    {
        if (!file_exists($sourcePath)) {
            return null;
        }

        $info = @getimagesize($sourcePath);
        if (!$info) {
            return null;
        }

        $mime = $info['mime'];
        $image = null;

        switch ($mime) {
            case 'image/jpeg':
                $image = @imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = @imagecreatefrompng($sourcePath);
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
                break;
            case 'image/webp':
                return $sourcePath;
        }

        if (!$image) {
            return null;
        }

        $destinationPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $sourcePath);
        if (@imagewebp($image, $destinationPath, $quality)) {
            imagedestroy($image);
            return $destinationPath;
        }

        imagedestroy($image);
        return null;
    }

    /**
     * Format a display URL for any image (local, remote, or fallback SVG).
     */
    public static function getUrl(?string $path, string $fallback = ''): string
    {
        if (empty($path)) {
            return $fallback;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (Str::startsWith($path, 'images/')) {
            return asset($path);
        }

        return asset(Str::startsWith($path, 'storage/') ? $path : 'storage/' . ltrim($path, '/'));
    }
}
