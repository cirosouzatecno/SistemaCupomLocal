@props([
    'label' => null,
    'name' => null,
    'checked' => false,
    'id' => null,
])

@php
    $toggleId = $id ?? $name ?? ('toggle-' . uniqid());
@endphp

<label for="{{ $toggleId }}" class="flex items-center gap-3 text-sm text-text">
    <input
        id="{{ $toggleId }}"
        name="{{ $name }}"
        type="checkbox"
        class="peer sr-only"
        @checked($checked)
        {{ $attributes->except('class') }}
    />
    <span class="relative h-6 w-11 rounded-full bg-surface-soft border border-border transition peer-checked:bg-brand-600 peer-checked:border-brand-600">
        <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-soft-1 transition peer-checked:translate-x-5"></span>
    </span>
    <span>{{ $label ?? $slot }}</span>
</label>
