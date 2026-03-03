@extends('layouts.app')

@section('title', 'Meu Painel — Cupons Locais')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Olá, {{ $user->name }}! 👋</h1>
            <p class="text-gray-400 text-sm mt-1">Bem-vindo(a) de volta à sua carteira de cupons.</p>
        </div>
        <a href="{{ route('coupons.index') }}"
           class="hidden sm:inline-block bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            + Explorar Cupons
        </a>
    </div>

    {{-- Contadores --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
            <p class="text-3xl font-extrabold text-brand-500">{{ $totalAtivos }}</p>
            <p class="text-xs text-gray-400 mt-1 uppercase tracking-wide">Ativos</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
            <p class="text-3xl font-extrabold text-green-500">{{ $totalUsados }}</p>
            <p class="text-xs text-gray-400 mt-1 uppercase tracking-wide">Usados</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
            <p class="text-3xl font-extrabold text-gray-400">{{ $totalExpirados }}</p>
            <p class="text-xs text-gray-400 mt-1 uppercase tracking-wide">Expirados</p>
        </div>
    </div>

    {{-- Ações rápidas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
        <a href="{{ route('user.meus-cupons') }}"
           class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 hover:shadow-md flex items-center gap-4 transition group">
            <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition">
                🎟️
            </div>
            <div>
                <h2 class="font-semibold text-gray-700">Meus Cupons</h2>
                <p class="text-xs text-gray-400 mt-0.5">Visualize seus QR Codes e histórico</p>
            </div>
        </a>

        <a href="{{ route('coupons.index') }}"
           class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 hover:shadow-md flex items-center gap-4 transition group">
            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition">
                🔍
            </div>
            <div>
                <h2 class="font-semibold text-gray-700">Explorar Cupons</h2>
                <p class="text-xs text-gray-400 mt-0.5">Encontre novos descontos perto de você</p>
            </div>
        </a>
    </div>

    {{-- Cupons recentes --}}
    @if ($recentCoupons->isNotEmpty())
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-gray-700">Adicionados recentemente</h2>
                <a href="{{ route('user.meus-cupons') }}" class="text-xs text-brand-600 hover:underline">Ver todos</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($recentCoupons as $uc)
                    @include('user.meus-cupons._card', ['userCoupon' => $uc])
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
