@extends('theme.layouts.app')

@section('title', 'Tema Azul — Home')
@section('withSidebar', 'false')

@section('header')
    <div class="bg-surface">
        <x-theme.navbar />
    </div>
@endsection

@section('content')
<section class="theme-hero-gradient text-white">
    <div class="theme-container py-16 sm:py-20">
        <div class="max-w-2xl space-y-6">
            <p class="text-xs uppercase tracking-[0.3em] text-white/70">@lang('theme.home.kicker')</p>
            <h1 class="text-3xl font-semibold leading-tight sm:text-4xl">@lang('theme.home.title')</h1>
            <p class="text-base text-white/75">@lang('theme.home.subtitle')</p>
            <div class="flex flex-wrap gap-3">
                <x-theme.button size="lg">@lang('theme.actions.start')</x-theme.button>
                <x-theme.button variant="ghost" size="lg" class="text-white hover:bg-white/10">@lang('theme.actions.tour')</x-theme.button>
            </div>
            <div class="flex flex-wrap gap-6 text-sm text-white/70">
                <div>
                    <p class="text-lg font-semibold text-white">{{ $stats['companies'] }}</p>
                    <p>@lang('theme.home.stats_companies')</p>
                </div>
                <div>
                    <p class="text-lg font-semibold text-white">{{ $stats['growth'] }}</p>
                    <p>@lang('theme.home.stats_growth')</p>
                </div>
                <div>
                    <p class="text-lg font-semibold text-white">{{ $stats['tickets'] }}</p>
                    <p>@lang('theme.home.stats_tickets')</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="theme-container py-12 sm:py-14">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-text">@lang('theme.home.features_title')</h2>
            <p class="text-sm text-text-muted">@lang('theme.home.features_subtitle')</p>
        </div>
        <x-theme.button variant="secondary" size="sm">@lang('theme.actions.view_all')</x-theme.button>
    </div>

    <div class="mt-8">
        @include('theme.partials.feature-list', ['features' => $features])
    </div>
</section>

<section class="theme-container pb-14">
    <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <x-theme.card title="@lang('theme.home.workflow_title')" subtitle="@lang('theme.home.workflow_subtitle')">
            <img
                src="{{ asset('assets/theme/placeholder.svg') }}"
                alt="@lang('theme.home.workflow_title')"
                class="w-full rounded-2xl border border-border bg-surface"
                loading="lazy"
                decoding="async"
            />
            <div class="space-y-3 text-sm text-text-muted">
                <p>@lang('theme.home.workflow_step_one')</p>
                <p>@lang('theme.home.workflow_step_two')</p>
                <p>@lang('theme.home.workflow_step_three')</p>
            </div>
            <x-slot name="footer">
                <div class="flex flex-wrap gap-3">
                    <x-theme.button size="sm">@lang('theme.actions.start')</x-theme.button>
                    <x-theme.button variant="secondary" size="sm">@lang('theme.actions.contact')</x-theme.button>
                </div>
            </x-slot>
        </x-theme.card>

        @include('theme.partials.cta')
    </div>
</section>
@endsection
