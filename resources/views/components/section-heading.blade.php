@props([
    'title',
    'subtitle' => null,
])

<div style="margin-bottom: 48px;">
    <h2>{{ $title }}</h2>
    @if($subtitle)
        <p style="margin-top: 12px; max-width: 680px;">{{ $subtitle }}</p>
    @endif
</div>
