@php
    $title = $title ?? 'Nada por aqui';
    $body = $body ?? 'Quando houver dados, eles aparecerão nesta seção.';
@endphp

<div class="theme-card flex flex-col items-center justify-center gap-4 p-10 text-center">
    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-brand-100 text-brand-700">
        <x-theme.icon name="info" class="h-6 w-6" />
    </div>
    <div class="space-y-2">
        <p class="text-base font-semibold text-text">{{ $title }}</p>
        <p class="text-sm text-text-muted">{{ $body }}</p>
    </div>
    @if (!empty($action))
        <div>{{ $action }}</div>
    @endif
</div>
