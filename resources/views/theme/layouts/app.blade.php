@php
    $pageTitle = trim($__env->yieldContent('title', 'Tema Azul Escuro'));
    $withSidebar = trim($__env->yieldContent('withSidebar', 'true')) !== 'false';
    $bodyClass = trim($__env->yieldContent('bodyClass', ''));
    $mainClass = trim($__env->yieldContent('mainClass', ''));
@endphp

<x-theme.layout :title="$pageTitle" :with-sidebar="$withSidebar" :body-class="$bodyClass" :main-class="$mainClass">
    @hasSection('header')
        <x-slot name="header">
            @yield('header')
        </x-slot>
    @endif

    @hasSection('sidebar')
        <x-slot name="sidebar">
            @yield('sidebar')
        </x-slot>
    @endif

    @hasSection('footer')
        <x-slot name="footer">
            @yield('footer')
        </x-slot>
    @endif

    @yield('content')
</x-theme.layout>
