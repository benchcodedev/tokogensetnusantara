@props([
    'src' => null,
    'alt' => 'Foto Toko Genset Nusantara',
    'aspect' => '4/3',
    'class' => '',
])

@php
    $resolvedUrl = null;
    if (!empty($src)) {
        if (str_starts_with($src, 'http://') || str_starts_with($src, 'https://')) {
            $resolvedUrl = $src;
        } elseif (str_starts_with($src, 'storage/') || str_starts_with($src, '/storage/')) {
            $path = ltrim($src, '/');
            if (file_exists(public_path($path))) {
                $resolvedUrl = asset($path);
            }
        } else {
            $path = ltrim($src, '/');
            if (file_exists(public_path($path))) {
                $resolvedUrl = asset($path);
            }
        }
    }
@endphp

@if($resolvedUrl)
    <img 
        src="{{ $resolvedUrl }}" 
        alt="{{ $alt }}" 
        loading="lazy" 
        class="{{ $class }}"
        style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: {{ $aspect }};"
    >
@else
    <div class="photo-placeholder {{ $class }}" style="aspect-ratio: {{ $aspect }};">
        <span>Foto belum diunggah</span>
    </div>
@endif
