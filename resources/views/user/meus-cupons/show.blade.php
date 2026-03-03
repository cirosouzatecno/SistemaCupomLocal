@extends('layouts.app')

@section('title', $userCoupon->coupon->title . ' — Meu Cupom')

@section('content')
<div class="max-w-lg mx-auto px-4 py-10">

    {{-- Voltar --}}
    <a href="{{ route('user.meus-cupons') }}"
       class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-brand-600 mb-6 transition">
        ← Voltar para Meus Cupons
    </a>

    {{-- ─── Card principal ──────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">

        {{-- Header colorido --}}
        <div class="
            @if($userCoupon->status === 'active')  bg-gradient-to-br from-brand-500 to-orange-400
            @elseif($userCoupon->status === 'used') bg-gradient-to-br from-green-500 to-emerald-400
            @else bg-gradient-to-br from-gray-400 to-gray-300
            @endif
            text-white px-6 py-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-orange-100 text-sm mb-1">{{ $userCoupon->coupon->merchant->name }}</p>
                    <h1 class="text-xl font-extrabold leading-tight">{{ $userCoupon->coupon->title }}</h1>
                </div>
                <span class="bg-white/20 text-white font-bold text-lg px-3 py-1 rounded-xl whitespace-nowrap">
                    {{ $userCoupon->coupon->formattedDiscount() }} OFF
                </span>
            </div>

            {{-- Status badge --}}
            <div class="mt-4">
                @if ($userCoupon->status === 'active')
                    <span class="inline-flex items-center gap-1 bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full">
                        ✅ Válido — apresente na loja
                    </span>
                @elseif ($userCoupon->status === 'used')
                    <span class="inline-flex items-center gap-1 bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full">
                        ✔️ Cupom já utilizado em {{ $userCoupon->used_at?->format('d/m/Y \à\s H:i') }}
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full">
                        🔒 Cupom expirado
                    </span>
                @endif
            </div>
        </div>

        <div class="px-6 py-6">

            {{-- ─── QR Code ────────────────────────────────────────────────── --}}
            @if ($userCoupon->status === 'active' && $qrCode)
                <div class="text-center mb-6">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-3 font-medium">
                        Mostre este QR Code para o lojista
                    </p>
                    <div class="inline-block p-3 bg-white border-4 border-brand-500 rounded-2xl shadow-md">
                        {!! $qrCode !!}
                    </div>
                    <p class="text-xs text-gray-400 mt-3 font-mono break-all">
                        {{ $userCoupon->qr_code_token }}
                    </p>
                </div>

                {{-- Instrução --}}
                <div class="bg-brand-50 border border-brand-200 rounded-xl px-4 py-3 text-sm text-brand-700 text-center mb-4">
                    💡 O lojista vai escanear ou digitar o código acima para validar o desconto.
                </div>

            @elseif ($userCoupon->status === 'used')
                <div class="text-center py-6">
                    <div class="text-5xl mb-3">✅</div>
                    <p class="text-gray-700 font-semibold">Este cupom já foi utilizado!</p>
                    @if ($userCoupon->used_at)
                        <p class="text-sm text-gray-400 mt-1">
                            Validado em {{ $userCoupon->used_at->format('d/m/Y \à\s H:i') }}
                        </p>
                    @endif
                    <p class="text-xs text-red-400 mt-3 font-medium">⚠️ Inválido para novo uso</p>
                </div>

            @else
                <div class="text-center py-6">
                    <div class="text-5xl mb-3">🔒</div>
                    <p class="text-gray-600 font-semibold">Este cupom expirou</p>
                    <p class="text-sm text-gray-400 mt-1">
                        Era válido até {{ $userCoupon->coupon->end_date->format('d/m/Y') }}
                    </p>
                </div>
            @endif

            {{-- ─── Detalhes do cupom ──────────────────────────────────────── --}}
            <div class="mt-2 space-y-2 text-sm text-gray-600 border-t border-gray-100 pt-4">
                @if ($userCoupon->coupon->description)
                    <p>{{ $userCoupon->coupon->description }}</p>
                @endif
                <ul class="mt-3 space-y-1.5">
                    <li>📅 Válido de <strong>{{ $userCoupon->coupon->start_date->format('d/m/Y') }}</strong>
                        até <strong>{{ $userCoupon->coupon->end_date->format('d/m/Y') }}</strong></li>
                    @if ($userCoupon->coupon->min_value)
                        <li>💰 Consumo mínimo: <strong>R$ {{ number_format($userCoupon->coupon->min_value, 2, ',', '.') }}</strong></li>
                    @endif
                    @if ($userCoupon->coupon->merchant->address)
                        <li>📍 {{ $userCoupon->coupon->merchant->address }}
                            @if ($userCoupon->coupon->merchant->neighborhood)
                                — {{ $userCoupon->coupon->merchant->neighborhood }}
                            @endif
                        </li>
                    @endif
                    @if ($userCoupon->coupon->merchant->whatsapp)
                        <li>
                            📞 <a href="https://wa.me/55{{ preg_replace('/\D/', '', $userCoupon->coupon->merchant->whatsapp) }}"
                                  target="_blank"
                                  class="text-green-600 hover:underline font-medium">
                                {{ $userCoupon->coupon->merchant->whatsapp }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>

        {{-- Rodapé do card --}}
        <div class="px-6 pb-4">
            <a href="{{ route('coupons.index') }}"
               class="block w-full text-center border border-gray-200 text-gray-500 hover:bg-gray-50 text-sm font-medium py-2.5 rounded-xl transition">
                Explorar mais cupons
            </a>
        </div>
    </div>

</div>
@endsection
