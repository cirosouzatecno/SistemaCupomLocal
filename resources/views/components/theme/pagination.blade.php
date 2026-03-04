@props([
    'current' => 2,
    'total' => 5,
])

@php
    $current = max(1, (int) $current);
    $total = max(1, (int) $total);
@endphp

<nav class="flex flex-wrap items-center gap-2" aria-label="Paginação">
    <button class="rounded-xl border border-border bg-surface px-3 py-2 text-xs text-text-muted hover:bg-surface-alt" @disabled($current === 1)>
        <x-theme.icon name="chevron-left" class="h-4 w-4" />
    </button>

    @for ($i = 1; $i <= $total; $i++)
        <button class="rounded-xl px-3 py-2 text-xs font-semibold {{ $i === $current ? 'bg-brand-600 text-white' : 'border border-border bg-surface text-text hover:bg-surface-alt' }}">
            {{ $i }}
        </button>
    @endfor

    <button class="rounded-xl border border-border bg-surface px-3 py-2 text-xs text-text-muted hover:bg-surface-alt" @disabled($current === $total)>
        <x-theme.icon name="chevron-right" class="h-4 w-4" />
    </button>
</nav>
