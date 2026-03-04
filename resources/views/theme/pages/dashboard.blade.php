@extends('theme.layouts.app')

@section('title', 'Tema Azul — Dashboard')

@section('content')
<div class="theme-container space-y-8 py-8">
    <div>
        <h1 class="text-2xl font-semibold text-text">@lang('theme.dashboard.title')</h1>
        <p class="text-sm text-text-muted">@lang('theme.dashboard.subtitle')</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($metrics as $metric)
            @include('theme.partials.metric-card', $metric)
        @endforeach
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <x-theme.card title="@lang('theme.dashboard.chart_title')" subtitle="@lang('theme.dashboard.chart_subtitle')">
            <div class="space-y-4">
                <div class="flex items-center justify-between text-xs text-text-muted">
                    <span>@lang('theme.dashboard.chart_period')</span>
                    <span>@lang('theme.dashboard.chart_hint')</span>
                </div>
                <div class="h-56 rounded-2xl border border-dashed border-border bg-surface-alt p-4">
                    <div class="flex h-full items-end gap-3">
                        @foreach ($chart as $bar)
                            <div class="flex-1">
                                <div
                                    class="rounded-xl bg-brand-500/70"
                                    style="height: {{ $bar['value'] }}%"
                                ></div>
                                <p class="mt-2 text-center text-[11px] text-text-subtle">{{ $bar['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </x-theme.card>

        <x-theme.card title="@lang('theme.dashboard.activity_title')" subtitle="@lang('theme.dashboard.activity_subtitle')">
            <div class="space-y-3">
                @foreach ($activities as $activity)
                    @include('theme.partials.activity-item', ['item' => $activity])
                @endforeach
            </div>
        </x-theme.card>
    </div>
</div>
@endsection
