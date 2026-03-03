@extends('layouts.app')

@section('title', $coupon->title . ' — ' . $coupon->merchant->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-xs text-gray-400 mb-6 flex items-center gap-1">
        <a href="{{ route('home') }}" class="hover:text-brand-500 transition">Início</a>
        <span>/</span>
        @if ($coupon->category)
            <span>{{ $coupon->category }}</span>
            <span>/</span>
        @endif
        <span class="text-gray-600">{{ $coupon->title }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- ─── Imagem ───────────────────────────────────────────────────── --}}
        <div class="rounded-2xl overflow-hidden bg-brand-50 flex items-center justify-center min-h-52 border border-gray-100">
            @if ($coupon->image_path)
                <img src="{{ asset('storage/' . $coupon->image_path) }}"
                     alt="{{ $coupon->title }}"
                     class="w-full h-72 object-cover">
            @else
                <span class="text-8xl">🏷️</span>
            @endif
        </div>

        {{-- ─── Detalhes ─────────────────────────────────────────────────── --}}
        <div class="flex flex-col justify-between">
            <div>
                {{-- Lojista --}}
                <div class="flex items-center gap-3 mb-4">
                    @if ($coupon->merchant->logo_path)
                        <img src="{{ asset('storage/' . $coupon->merchant->logo_path) }}"
                             alt="{{ $coupon->merchant->name }}"
                             class="w-10 h-10 rounded-full object-cover border border-gray-200">
                    @else
                        <div class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 font-bold text-sm">
                            {{ mb_substr($coupon->merchant->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <p class="font-semibold text-gray-700 text-sm">{{ $coupon->merchant->name }}</p>
                        @if ($coupon->merchant->neighborhood)
                            <p class="text-xs text-gray-400">
                                📍 {{ $coupon->merchant->neighborhood }}
                                @if ($coupon->merchant->city), {{ $coupon->merchant->city }}@endif
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Título --}}
                <h1 class="text-2xl font-extrabold text-gray-800 mb-2 leading-tight">
                    {{ $coupon->title }}
                </h1>

                {{-- Badge de desconto --}}
                <span class="inline-block bg-brand-500 text-white text-lg font-bold px-4 py-1.5 rounded-full mb-4 shadow">
                    {{ $coupon->formattedDiscount() }} de desconto
                </span>

                {{-- Descrição --}}
                @if ($coupon->description)
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        {{ $coupon->description }}
                    </p>
                @endif

                {{-- Informações extras --}}
                <ul class="text-sm text-gray-500 space-y-1 mb-6">
                    @if ($coupon->min_value)
                        <li>💰 Valor mínimo: <strong>R$ {{ number_format($coupon->min_value, 2, ',', '.') }}</strong></li>
                    @endif
                    <li>📅 Válido de <strong>{{ $coupon->start_date->format('d/m/Y') }}</strong>
                        até <strong>{{ $coupon->end_date->format('d/m/Y') }}</strong></li>
                    <li>👤 Limite por usuário: <strong>{{ $coupon->per_user_limit }}</strong></li>
                    @if ($coupon->category)
                        <li>🏷️ Categoria: <strong>{{ $coupon->category }}</strong></li>
                    @endif
                </ul>
            </div>

            {{-- ─── CTA ──────────────────────────────────────────────────── --}}
            @auth('web')
                @if ($jaAdicionado)
                    <div class="bg-green-50 border border-green-300 text-green-700 rounded-xl px-5 py-4 text-center">
                        <span class="text-xl">✅</span>
                        <p class="font-semibold mt-1">Cupom já adicionado!</p>
                        <a href="{{ route('user.meus-cupons') }}"
                           class="mt-2 inline-block text-sm text-green-600 underline hover:text-green-700">
                            Ver Meus Cupons
                        </a>
                    </div>
                @else
                    <form method="POST" action="{{ route('user.coupons.store', $coupon) }}">
                        @csrf
                        <button type="submit"
                                class="w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 rounded-xl text-base transition shadow-md active:scale-95">
                            🎟️ Adicionar cupom
                        </button>
                    </form>
                @endif
            @else
                {{-- Visitante: redireciona para login --}}
                <a href="{{ route('user.login') }}?redirect={{ urlencode(request()->url()) }}"
                   class="block w-full text-center bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 rounded-xl text-base transition shadow-md">
                    🎟️ Entrar para adicionar cupom
                </a>
                <p class="text-center text-xs text-gray-400 mt-2">
                    Não tem conta?
                    <a href="{{ route('user.register') }}" class="text-brand-600 hover:underline">Cadastre-se grátis</a>
                </p>
            @endauth

        </div>
    </div>

    {{-- ─── Outros cupons do lojista ───────────────────────────────────── --}}
    @if ($outroCupons->isNotEmpty())
        <div class="mt-14">
            <h2 class="text-lg font-bold text-gray-700 mb-5">
                Outros cupons de <span class="text-brand-600">{{ $coupon->merchant->name }}</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($outroCupons as $outro)
                    @include('partials._coupon-card', ['coupon' => $outro])
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
