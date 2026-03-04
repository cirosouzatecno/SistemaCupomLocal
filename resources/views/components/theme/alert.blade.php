@props([
    'type' => 'info',
    'title' => null,
])

@php
    $styles = [
        'success' => 'border-green-200 bg-green-50 text-green-700',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-700',
        'error' => 'border-red-200 bg-red-50 text-red-700',
        'info' => 'border-blue-200 bg-blue-50 text-blue-700',
    ];

    $icons = [
        'success' => 'check',
        'warning' => 'alert',
        'error' => 'alert',
        'info' => 'info',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'flex gap-3 rounded-2xl border px-4 py-3 text-sm ' . ($styles[$type] ?? $styles['info'])]) }}>
    <x-theme.icon :name="$icons[$type] ?? 'info'" class="h-5 w-5" />
    <div>
        @if ($title)
            <p class="font-semibold">{{ $title }}</p>
        @endif
        <div class="text-sm">{{ $slot }}</div>
    </div>
</div>
