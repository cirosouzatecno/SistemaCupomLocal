@php($item = $item ?? [])

<div class="flex items-start justify-between rounded-2xl border border-border bg-surface px-4 py-3">
    <div class="space-y-1">
        <p class="text-sm font-semibold text-text">{{ $item['title'] ?? 'Atividade' }}</p>
        <p class="text-xs text-text-muted">{{ $item['time'] ?? 'Agora mesmo' }}</p>
    </div>
    <x-theme.badge :variant="$item['variant'] ?? 'neutral'">
        {{ $item['status'] ?? 'Em andamento' }}
    </x-theme.badge>
</div>
