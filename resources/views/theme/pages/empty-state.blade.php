@extends('theme.layouts.app')

@section('title', 'Tema Azul — Estado vazio')

@section('content')
<div class="theme-container py-10 space-y-6">
    @include('theme.partials.empty-state', [
        'title' => __('theme.empty.title'),
        'body' => __('theme.empty.body')
    ])
    <div class="flex justify-center">
        <x-theme.button>@lang('theme.actions.new')</x-theme.button>
    </div>
</div>
@endsection
