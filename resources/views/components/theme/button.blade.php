@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center rounded-xl font-semibold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/40 disabled:cursor-not-allowed disabled:opacity-60';

    $variants = [
        'primary' => 'bg-brand-600 text-white hover:bg-brand-700 shadow-soft-1',
        'secondary' => 'border border-border bg-surface text-text hover:bg-surface-alt',
        'ghost' => 'text-text hover:bg-surface-alt',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'outline' => 'border border-border text-text hover:bg-surface-alt',
    ];

    $sizes = [
        'sm' => 'px-3 py-2 text-xs',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-5 py-3 text-base',
    ];

    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);

    $isLink = $attributes->has('href');
@endphp

@if ($isLink)
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
