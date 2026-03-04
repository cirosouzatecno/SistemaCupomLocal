@props([
    'label' => null,
    'name' => null,
    'checked' => false,
    'id' => null,
])

@php
    $checkboxId = $id ?? $name ?? ('checkbox-' . uniqid());
@endphp

<label for="{{ $checkboxId }}" class="flex items-start gap-3 text-sm text-text">
    <input
        id="{{ $checkboxId }}"
        name="{{ $name }}"
        type="checkbox"
        @checked($checked)
        {{ $attributes->merge(['class' => 'mt-1 h-4 w-4 rounded border-border text-brand-600 focus:ring-brand-500']) }}
    />
    <span>{{ $label ?? $slot }}</span>
</label>
