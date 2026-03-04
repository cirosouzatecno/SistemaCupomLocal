@props([
    'variant' => 'neutral',
])

@php
    $variants = [
        'neutral' => 'bg-surface-soft text-text-muted',
        'brand' => 'bg-brand-100 text-brand-700',
        'success' => 'bg-green-100 text-green-700',
        'warning' => 'bg-amber-100 text-amber-700',
        'error' => 'bg-red-100 text-red-700',
        'info' => 'bg-blue-100 text-blue-700',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'theme-badge ' . ($variants[$variant] ?? $variants['neutral'])]) }}>
    {{ $slot }}
</span>
