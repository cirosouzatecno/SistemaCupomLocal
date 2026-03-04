@extends('theme.layouts.app')

@section('title', 'Tema Azul — Cadastro')
@section('withSidebar', 'false')

@section('header')
    @include('theme.partials.auth-header')
@endsection

@section('content')
<section class="theme-container flex min-h-[70vh] items-center justify-center py-12">
    <div class="w-full max-w-lg">
        <x-theme.card class="p-8" title="@lang('theme.auth.register_title')" subtitle="@lang('theme.auth.register_subtitle')">
            <form class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <x-theme.input name="first_name" label="@lang('theme.auth.first_name')" placeholder="Maria" />
                </div>
                <div class="sm:col-span-1">
                    <x-theme.input name="last_name" label="@lang('theme.auth.last_name')" placeholder="Souza" />
                </div>
                <div class="sm:col-span-2">
                    <x-theme.input name="email" type="email" label="@lang('theme.auth.email')" placeholder="nome@empresa.com" />
                </div>
                <div class="sm:col-span-2">
                    <x-theme.input name="company" label="@lang('theme.auth.company')" placeholder="InovaTech" />
                </div>
                <div class="sm:col-span-1">
                    <x-theme.input name="password" type="password" label="@lang('theme.auth.password')" placeholder="••••••••" />
                </div>
                <div class="sm:col-span-1">
                    <x-theme.input name="password_confirmation" type="password" label="@lang('theme.auth.password_confirm')" placeholder="••••••••" />
                </div>
                <div class="sm:col-span-2">
                    <x-theme.checkbox name="terms" label="@lang('theme.auth.terms')" />
                </div>
                <div class="sm:col-span-2">
                    <x-theme.button class="w-full">@lang('theme.actions.register')</x-theme.button>
                </div>
            </form>

            <x-slot name="footer">
                <p class="text-sm text-text-muted">
                    @lang('theme.auth.have_account')
                    <a href="{{ route('admin.theme.login') }}" class="text-brand-600 hover:underline">@lang('theme.actions.login')</a>
                </p>
            </x-slot>
        </x-theme.card>
    </div>
</section>
@endsection
