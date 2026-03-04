@extends('theme.layouts.app')

@section('title', 'Tema Azul — 500')
@section('withSidebar', 'false')

@section('header')
    @include('theme.partials.auth-header')
@endsection

@section('content')
<section class="theme-container flex min-h-[70vh] items-center justify-center py-12">
    <div class="max-w-md text-center space-y-4">
        <p class="text-xs uppercase tracking-[0.3em] text-text-subtle">@lang('theme.errors.kicker')</p>
        <h1 class="text-4xl font-semibold text-text">500</h1>
        <p class="text-sm text-text-muted">@lang('theme.errors.server')</p>
        <div class="flex flex-wrap justify-center gap-3">
            <x-theme.button>@lang('theme.actions.retry')</x-theme.button>
            <x-theme.button variant="secondary">@lang('theme.actions.contact')</x-theme.button>
        </div>
    </div>
</section>
@endsection
