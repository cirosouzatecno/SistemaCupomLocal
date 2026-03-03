@extends('layouts.app')

@section('title', 'Confirmar Uso — Validar Cupom')

@section('content')
<div class="max-w-lg mx-auto px-4 py-14">

    {{-- Cabeçalho --}}
    <div class="text-center mb-8">
        <div class="text-5xl mb-4">🎟️</div>
        <h1 class="text-2xl font-bold text-gray-800">Cupom Encontrado!</h1>
        <p class="text-sm text-gray-500 mt-2">Confira os dados abaixo antes de confirmar o uso</p>
    </div>

    {{-- Card com detalhes --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-50 overflow-hidden mb-6">

        {{-- Desconto destacado --}}
        <div class="bg-brand-50 px-6 py-5 text-center">
            <p class="text-xs text-brand-600 font-semibold uppercase tracking-wide mb-1">Desconto</p>
            <p class="text-4xl font-extrabold text-brand-600">{{ $userCoupon->coupon->formattedDiscount() }}</p>
            <p class="text-base font-semibold text-gray-700 mt-1">{{ $userCoupon->coupon->title }}</p>
            @if ($userCoupon->coupon->category)
                <span class="inline-block mt-2 bg-white text-gray-500 text-xs font-medium px-3 py-1 rounded-full border border-gray-200">
                    {{ $userCoupon->coupon->category }}
                </span>
            @endif
        </div>

        {{-- Dados do cupom --}}
        <div class="px-6 py-4 space-y-3">
            @if ($userCoupon->coupon->description)
                <div>
                    <p class="text-xs text-gray-400 font-medium uppercase mb-0.5">Descrição</p>
                    <p class="text-sm text-gray-700">{{ $userCoupon->coupon->description }}</p>
                </div>
            @endif

            @if ($userCoupon->coupon->min_value)
                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-500">Valor mínimo</p>
                    <p class="text-sm font-semibold text-gray-700">
                        R$ {{ number_format($userCoupon->coupon->min_value, 2, ',', '.') }}
                    </p>
                </div>
            @endif

            <div class="flex items-center justify-between">
                <p class="text-xs text-gray-500">Válido até</p>
                <p class="text-sm font-semibold text-gray-700">
                    {{ $userCoupon->coupon->end_date->format('d/m/Y') }}
                </p>
            </div>
        </div>

        {{-- Dados do cliente --}}
        <div class="px-6 py-4 space-y-3">
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide">Cliente</p>

            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 font-bold text-sm">
                    {{ strtoupper(substr($userCoupon->user->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ $userCoupon->user->name }}</p>
                    @if ($userCoupon->user->whatsapp)
                        <p class="text-xs text-gray-400">{{ $userCoupon->user->whatsapp }}</p>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-between">
                <p class="text-xs text-gray-500">Adicionado em</p>
                <p class="text-sm text-gray-700">{{ $userCoupon->created_at->format('d/m/Y \à\s H:i') }}</p>
            </div>
        </div>

        {{-- Código (token) --}}
        <div class="px-6 py-3 bg-gray-50">
            <p class="text-xs text-gray-400 mb-0.5">Código</p>
            <p class="text-xs font-mono text-gray-500 break-all">{{ $token }}</p>
        </div>
    </div>

    {{-- Ações --}}
    <div class="flex flex-col gap-3">

        {{-- Confirmar uso --}}
        <form method="POST" action="{{ route('merchant.validate.confirm') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <button type="submit"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3.5 rounded-xl transition shadow-sm text-sm">
                ✅ Confirmar uso do cupom
            </button>
        </form>

        {{-- Cancelar --}}
        <a href="{{ route('merchant.validate.form') }}"
           class="w-full text-center border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium py-3 rounded-xl transition text-sm">
            Cancelar
        </a>
    </div>

    {{-- Aviso --}}
    <p class="text-xs text-center text-gray-400 mt-5">
        ⚠️ Ao confirmar, o cupom será marcado como <strong>utilizado</strong> e não poderá ser usado novamente.
    </p>

</div>
@endsection
