<div class="theme-container flex items-center justify-between py-4">
    <div class="flex items-center gap-3">
        <button
            type="button"
            data-sidebar-toggle
            aria-expanded="false"
            class="inline-flex items-center justify-center rounded-xl border border-border bg-surface px-3 py-2 text-text lg:hidden"
        >
            <x-theme.icon name="menu" class="h-5 w-5" />
        </button>
        <div>
            <p class="text-sm font-semibold text-text">@lang('theme.header.title')</p>
            <p class="text-xs text-text-muted">@lang('theme.header.subtitle')</p>
        </div>
    </div>

    <div class="hidden w-[280px] md:block">
        <label class="relative block">
            <span class="sr-only">@lang('theme.actions.search')</span>
            <span class="absolute inset-y-0 left-3 flex items-center text-text-muted">
                <x-theme.icon name="search" class="h-4 w-4" />
            </span>
            <input
                type="text"
                placeholder="@lang('theme.actions.search_placeholder')"
                class="w-full rounded-xl border border-border bg-surface py-2 pl-9 pr-3 text-sm text-text placeholder:text-text-subtle focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30"
            />
        </label>
    </div>

    <div class="flex items-center gap-3">
        <x-theme.button variant="secondary" size="sm" class="hidden sm:inline-flex">
            <x-theme.icon name="plus" class="mr-2 h-4 w-4" />
            @lang('theme.actions.new')
        </x-theme.button>

        <button
            data-theme-toggle
            aria-label="Alternar tema"
            title="Alternar tema claro/escuro"
            class="inline-flex items-center gap-2 rounded-xl border border-border bg-surface px-3 py-2 text-sm text-text hover:bg-surface-alt"
        >
            <span data-theme-icon aria-hidden="true">🌙</span>
            <span data-theme-label class="sr-only">Modo escuro</span>
        </button>

        <div class="relative" data-dropdown>
            <button
                type="button"
                data-dropdown-toggle
                aria-expanded="false"
                class="inline-flex items-center gap-3 rounded-2xl border border-border bg-surface px-3 py-2 text-sm text-text hover:bg-surface-alt"
            >
                <span class="h-8 w-8 rounded-full bg-brand-500/20 text-brand-700 flex items-center justify-center text-xs font-semibold">
                    AD
                </span>
                <span class="hidden sm:inline">@lang('theme.header.user')</span>
                <x-theme.icon name="chevron-down" class="h-4 w-4 text-text-muted" />
            </button>

            <div
                data-dropdown-menu
                class="absolute right-0 mt-2 hidden w-44 rounded-2xl border border-border bg-surface p-2 text-sm shadow-soft-2"
            >
                <a href="#" class="flex items-center gap-2 rounded-xl px-3 py-2 text-text hover:bg-surface-alt">
                    <x-theme.icon name="user" class="h-4 w-4" />
                    @lang('theme.header.profile')
                </a>
                <a href="#" class="flex items-center gap-2 rounded-xl px-3 py-2 text-text hover:bg-surface-alt">
                    <x-theme.icon name="settings" class="h-4 w-4" />
                    @lang('theme.header.settings')
                </a>
                <div class="my-1 border-t border-border"></div>
                <a href="#" class="flex items-center gap-2 rounded-xl px-3 py-2 text-red-600 hover:bg-red-50">
                    <x-theme.icon name="logout" class="h-4 w-4" />
                    @lang('theme.header.logout')
                </a>
            </div>
        </div>
    </div>
</div>
