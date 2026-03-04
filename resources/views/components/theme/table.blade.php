@props([
    'head' => null,
])

<div {{ $attributes->merge(['class' => 'theme-card overflow-hidden']) }}>
    <table class="w-full text-sm">
        @if (isset($head))
            <thead class="bg-surface-alt text-xs uppercase tracking-wide text-text-muted">
                {{ $head }}
            </thead>
        @endif
        <tbody class="divide-y divide-border">
            {{ $slot }}
        </tbody>
    </table>
</div>
