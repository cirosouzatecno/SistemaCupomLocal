@props([
    'title' => null,
    'subtitle' => null,
    'padding' => 'p-6',
])

<div {{ $attributes->merge(['class' => "theme-card {$padding}"]) }}>
    @if ($title)
        <div class="mb-4">
            <h3 class="text-base font-semibold text-text">{{ $title }}</h3>
            @if ($subtitle)
                <p class="text-sm text-text-muted">{{ $subtitle }}</p>
            @endif
        </div>
    @endif

    <div class="space-y-4">
        {{ $slot }}
    </div>

    @if (isset($footer))
        <div class="mt-6 border-t border-border pt-4">
            {{ $footer }}
        </div>
    @endif
</div>
