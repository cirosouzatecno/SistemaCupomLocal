@extends('theme.layouts.app')

@section('title', 'Tema Azul — Recuperar senha')
@section('withSidebar', 'false')

@section('header')
    @include('theme.partials.auth-header')
@endsection

@section('content')
<section class="theme-container flex min-h-[70vh] items-center justify-center py-12">
    <div class="w-full max-w-md">
        <x-theme.card class="p-8" title="@lang('theme.auth.forgot_title')" subtitle="@lang('theme.auth.forgot_subtitle')">
            <form class="space-y-4">
                <x-theme.input name="email" type="email" label="@lang('theme.auth.email')" placeholder="nome@empresa.com" />
                <x-theme.button class="w-full">@lang('theme.actions.reset')</x-theme.button>
            </form>

            <x-slot name="footer">
                <p class="text-sm text-text-muted">
                    @lang('theme.auth.back_login')
                    <a href="{{ route('admin.theme.login') }}" class="text-brand-600 hover:underline">@lang('theme.actions.login')</a>
                </p>
            </x-slot>
        </x-theme.card>
    </div>
</section>
@endsection
