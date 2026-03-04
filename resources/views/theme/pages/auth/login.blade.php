@extends('theme.layouts.app')

@section('title', 'Tema Azul — Login')
@section('withSidebar', 'false')

@section('header')
    @include('theme.partials.auth-header')
@endsection

@section('content')
<section class="theme-container flex min-h-[70vh] items-center justify-center py-12">
    <div class="w-full max-w-md">
        <x-theme.card class="p-8" title="@lang('theme.auth.login_title')" subtitle="@lang('theme.auth.login_subtitle')">
            <form class="space-y-4">
                <x-theme.input name="email" type="email" label="@lang('theme.auth.email')" placeholder="nome@empresa.com" />
                <x-theme.input name="password" type="password" label="@lang('theme.auth.password')" placeholder="••••••••" />

                <div class="flex items-center justify-between text-sm">
                    <x-theme.checkbox name="remember" label="@lang('theme.auth.remember')" />
                    <a href="{{ route('admin.theme.forgot') }}" class="text-brand-600 hover:underline">@lang('theme.auth.forgot')</a>
                </div>

                <x-theme.button class="w-full">@lang('theme.actions.login')</x-theme.button>
            </form>

            <x-slot name="footer">
                <p class="text-sm text-text-muted">
                    @lang('theme.auth.no_account')
                    <a href="{{ route('admin.theme.register') }}" class="text-brand-600 hover:underline">@lang('theme.actions.register')</a>
                </p>
            </x-slot>
        </x-theme.card>
    </div>
</section>
@endsection
