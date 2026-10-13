@props([
    'src' => '',
    'alt' => 'Abadi Jaya Furniture',
    'class' => '',
    'aspect' => '',
    'sizes' => '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw',
    'priority' => false,
])

@php
    $imageUrl = \App\Services\ImageService::getUrl($src);
    $srcset = \App\Services\ImageService::getSrcset($imageUrl);
@endphp

<div class="relative overflow-hidden bg-[#241B0E]/30 {{ $aspect }}">
    <img 
        src="{{ $imageUrl }}" 
        @if($srcset) srcset="{{ $srcset }}" sizes="{{ $sizes }}" @endif
        alt="{{ $alt }}"
        @if(!$priority) loading="lazy" decoding="async" @else fetchpriority="high" @endif
        {{ $attributes->merge(['class' => 'w-full h-full object-cover transition-transform duration-700 ease-out ' . $class]) }}
    />
</div>
