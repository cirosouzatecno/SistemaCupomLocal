@props([
    'id' => 'theme-modal',
    'title' => null,
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
    ];
@endphp

<div
    id="{{ $id }}"
    data-modal
    role="dialog"
    aria-modal="true"
    aria-hidden="true"
    hidden
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
>
    <div data-modal-overlay class="absolute inset-0 bg-slate-900/40"></div>

    <div class="relative w-full {{ $sizes[$size] ?? $sizes['md'] }} rounded-2xl border border-border bg-surface shadow-soft-3">
        <div class="flex items-center justify-between border-b border-border px-5 py-4">
            <div>
                @if ($title)
                    <h3 class="text-base font-semibold text-text">{{ $title }}</h3>
                @endif
            </div>
            <button type="button" data-modal-close class="rounded-xl p-2 text-text-muted hover:bg-surface-alt">
                <x-theme.icon name="x" class="h-4 w-4" />
            </button>
        </div>

        <div class="px-5 py-4 text-sm text-text">
            {{ $slot }}
        </div>

        @if (isset($footer))
            <div class="border-t border-border px-5 py-4">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
