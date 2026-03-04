@extends('theme.layouts.app')

@section('title', 'Tema Azul — Mobile')
@section('withSidebar', 'false')

@section('header')
    <div class="bg-surface">
        <x-theme.navbar />
    </div>
@endsection

@section('content')
<section class="theme-container py-10">
    <div class="mx-auto max-w-sm space-y-6">
        <x-theme.card class="p-6">
            <div class="flex items-center gap-3">
                <div class="h-12 w-12 rounded-2xl bg-brand-500/15 text-brand-700 flex items-center justify-center">
                    <x-theme.icon name="user" class="h-5 w-5" />
                </div>
                <div>
                    <p class="text-sm font-semibold text-text">@lang('theme.mobile.welcome')</p>
                    <p class="text-xs text-text-muted">@lang('theme.mobile.subtitle')</p>
                </div>
            </div>
        </x-theme.card>

        <x-theme.card>
            <div class="space-y-3">
                <x-theme.input label="@lang('theme.mobile.search')" placeholder="@lang('theme.mobile.search_placeholder')" />
                <x-theme.button class="w-full">@lang('theme.actions.start')</x-theme.button>
            </div>
        </x-theme.card>

        <x-theme.card>
            <div class="space-y-3">
                <p class="text-sm font-semibold text-text">@lang('theme.mobile.quick_actions')</p>
                <div class="grid grid-cols-2 gap-3">
                    <x-theme.button variant="secondary" size="sm">@lang('theme.actions.new')</x-theme.button>
                    <x-theme.button variant="secondary" size="sm">@lang('theme.actions.support')</x-theme.button>
                    <x-theme.button variant="secondary" size="sm">@lang('theme.actions.reports')</x-theme.button>
                    <x-theme.button variant="secondary" size="sm">@lang('theme.actions.settings')</x-theme.button>
                </div>
            </div>
        </x-theme.card>
    </div>
</section>
@endsection
