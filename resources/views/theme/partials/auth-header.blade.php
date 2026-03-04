<div class="theme-container flex items-center justify-between py-4">
    <div class="flex items-center gap-3">
        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-500/15 text-brand-700">
            <x-theme.icon name="spark" class="h-5 w-5" />
        </span>
        <div>
            <p class="text-sm font-semibold text-text">@lang('theme.brand.name')</p>
            <p class="text-xs text-text-muted">@lang('theme.brand.tagline')</p>
        </div>
    </div>

    <button
        data-theme-toggle
        aria-label="Alternar tema"
        class="inline-flex items-center gap-2 rounded-xl border border-border bg-surface px-3 py-2 text-sm text-text hover:bg-surface-alt"
    >
        <span data-theme-icon aria-hidden="true">🌙</span>
        <span data-theme-label class="sr-only">Modo escuro</span>
    </button>
</div>
