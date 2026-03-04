<nav class="theme-container flex items-center justify-between py-4">
    <div class="flex items-center gap-3">
        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-500/15 text-brand-700">
            <x-theme.icon name="spark" class="h-5 w-5" />
        </span>
        <div>
            <p class="text-sm font-semibold text-text">@lang('theme.brand.name')</p>
            <p class="text-xs text-text-muted">@lang('theme.brand.tagline')</p>
        </div>
    </div>

    <div class="hidden items-center gap-6 text-sm text-text-muted lg:flex">
        <a href="#" class="hover:text-text">@lang('theme.nav.product')</a>
        <a href="#" class="hover:text-text">@lang('theme.nav.features')</a>
        <a href="#" class="hover:text-text">@lang('theme.nav.pricing')</a>
        <a href="#" class="hover:text-text">@lang('theme.nav.contact')</a>
    </div>

    <div class="flex items-center gap-3">
        <x-theme.button variant="ghost" size="sm">@lang('theme.actions.login')</x-theme.button>
        <x-theme.button size="sm">@lang('theme.actions.start')</x-theme.button>
    </div>
</nav>
