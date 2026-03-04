@php($features = $features ?? [])

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($features as $feature)
        <x-theme.card class="p-5">
            <div class="flex items-start gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-500/10 text-brand-700">
                    <x-theme.icon :name="$feature['icon']" class="h-5 w-5" />
                </span>
                <div>
                    <p class="text-sm font-semibold text-text">{{ $feature['title'] }}</p>
                    <p class="text-sm text-text-muted">{{ $feature['description'] }}</p>
                </div>
            </div>
        </x-theme.card>
    @endforeach
</div>
