@extends('theme.layouts.app')

@section('title', 'Tema Azul — Perfil')

@section('content')
<div class="theme-container space-y-6 py-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-text">@lang('theme.profile.title')</h1>
            <p class="text-sm text-text-muted">@lang('theme.profile.subtitle')</p>
        </div>
        <x-theme.button size="sm">@lang('theme.actions.edit')</x-theme.button>
    </div>

    <div class="grid gap-6 lg:grid-cols-[0.7fr_1.3fr]">
        <x-theme.card>
            <div class="flex flex-col items-center gap-4">
                <div class="h-20 w-20 rounded-3xl bg-brand-500/15 text-brand-700 flex items-center justify-center text-2xl font-semibold">
                    CL
                </div>
                <div class="text-center">
                    <p class="text-lg font-semibold text-text">{{ $profile['name'] }}</p>
                    <p class="text-sm text-text-muted">{{ $profile['role'] }}</p>
                </div>
                <div class="flex gap-2">
                    <x-theme.badge variant="info">{{ $profile['status'] }}</x-theme.badge>
                    <x-theme.badge variant="brand">{{ $profile['plan'] }}</x-theme.badge>
                </div>
            </div>
        </x-theme.card>

        <x-theme.card title="@lang('theme.profile.details_title')">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs uppercase tracking-wide text-text-subtle">@lang('theme.profile.email')</p>
                    <p class="text-sm text-text">{{ $profile['email'] }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-text-subtle">@lang('theme.profile.phone')</p>
                    <p class="text-sm text-text">{{ $profile['phone'] }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-text-subtle">@lang('theme.profile.location')</p>
                    <p class="text-sm text-text">{{ $profile['location'] }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-text-subtle">@lang('theme.profile.team')</p>
                    <p class="text-sm text-text">{{ $profile['team'] }}</p>
                </div>
            </div>

            <x-slot name="footer">
                <div class="flex flex-wrap gap-3">
                    <x-theme.button size="sm">@lang('theme.actions.update')</x-theme.button>
                    <x-theme.button variant="secondary" size="sm">@lang('theme.actions.security')</x-theme.button>
                </div>
            </x-slot>
        </x-theme.card>
    </div>

    <x-theme.card title="@lang('theme.profile.security_title')" subtitle="@lang('theme.profile.security_subtitle')">
        <div class="grid gap-4 sm:grid-cols-2">
            <x-theme.input label="@lang('theme.profile.current_password')" type="password" />
            <x-theme.input label="@lang('theme.profile.new_password')" type="password" />
        </div>
    </x-theme.card>
</div>
@endsection
