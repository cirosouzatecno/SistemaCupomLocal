<div class="flex h-full flex-col">
    <div class="px-6 py-6">
        <div class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-500 text-white">
                <x-theme.icon name="spark" class="h-5 w-5" />
            </span>
            <div>
                <p class="text-sm font-semibold text-text">@lang('theme.brand.name')</p>
                <p class="text-xs text-text-muted">@lang('theme.brand.tagline')</p>
            </div>
        </div>
    </div>

    <nav class="flex-1 px-4">
        <p class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-text-subtle">@lang('theme.sidebar.main')</p>
        <div class="space-y-1">
            <a href="{{ route('admin.theme.dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-text hover:bg-surface-alt">
                <x-theme.icon name="home" class="h-4 w-4" />
                @lang('theme.sidebar.dashboard')
            </a>
            <a href="{{ route('admin.theme.items') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-text hover:bg-surface-alt">
                <x-theme.icon name="grid" class="h-4 w-4" />
                @lang('theme.sidebar.items')
            </a>
            <a href="{{ route('admin.theme.profile') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-text hover:bg-surface-alt">
                <x-theme.icon name="user" class="h-4 w-4" />
                @lang('theme.sidebar.profile')
            </a>
        </div>

        <p class="mt-6 px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-text-subtle">@lang('theme.sidebar.admin')</p>
        <div class="space-y-1">
            <a href="{{ route('admin.theme.admin-table') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-text hover:bg-surface-alt">
                <x-theme.icon name="users" class="h-4 w-4" />
                @lang('theme.sidebar.users')
            </a>
            <a href="{{ route('admin.theme.forms') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-text hover:bg-surface-alt">
                <x-theme.icon name="settings" class="h-4 w-4" />
                @lang('theme.sidebar.settings')
            </a>
        </div>
    </nav>

    <div class="mt-auto border-t border-border px-6 py-4">
        <div class="rounded-2xl bg-brand-500/10 p-4 text-xs text-text-muted">
            <p class="font-semibold text-text">@lang('theme.sidebar.tip_title')</p>
            <p class="mt-1">@lang('theme.sidebar.tip_body')</p>
        </div>
    </div>
</div>
