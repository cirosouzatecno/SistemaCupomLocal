@props([
    'label' => null,
    'name' => null,
    'hint' => null,
    'error' => null,
    'id' => null,
])

@php
    $selectId = $id ?? $name ?? ('select-' . uniqid());
    $hasError = $error || ($name && $errors->has($name));
    $errorMessage = $error ?? ($name ? $errors->first($name) : null);

    $base = 'w-full rounded-xl border bg-surface px-3 py-2.5 text-sm text-text focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30';
    $errorClass = $hasError ? 'border-red-500 focus:border-red-500 focus:ring-red-500/30' : 'border-border';
@endphp

<div class="space-y-2">
    @if ($label)
        <label for="{{ $selectId }}" class="text-sm font-medium text-text">
            {{ $label }}
        </label>
    @endif

    <select
        id="{{ $selectId }}"
        name="{{ $name }}"
        aria-invalid="{{ $hasError ? 'true' : 'false' }}"
        {{ $attributes->merge(['class' => $base . ' ' . $errorClass]) }}
    >
        {{ $slot }}
    </select>

    @if ($hasError)
        <p class="text-xs text-red-600">{{ $errorMessage }}</p>
    @elseif ($hint)
        <p class="text-xs text-text-muted">{{ $hint }}</p>
    @endif
</div>
