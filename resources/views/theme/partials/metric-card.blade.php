@php
    $title = $title ?? 'Métrica';
    $value = $value ?? '0';
    $trend = $trend ?? '+0%';
@endphp

<x-theme.card class="p-5">
    <div class="flex items-start justify-between">
        <div>
            <p class="text-xs uppercase tracking-wide text-text-subtle">{{ $title }}</p>
            <p class="mt-2 text-2xl font-semibold text-text">{{ $value }}</p>
        </div>
        <span class="text-xs font-semibold text-brand-700">{{ $trend }}</span>
    </div>
</x-theme.card>
