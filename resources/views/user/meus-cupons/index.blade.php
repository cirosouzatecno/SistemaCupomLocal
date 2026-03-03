@extends('layouts.app')

@section('title', 'Meus Cupons — Cupons Locais')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    {{-- Cabeçalho --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">🎟️ Meus Cupons</h1>
            <p class="text-sm text-gray-400 mt-1">Clique num cupom para ver o QR Code e usar na loja</p>
        </div>
        <a href="{{ route('coupons.index') }}"
           class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            + Explorar mais
        </a>
    </div>

    {{-- Contadores --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 text-center">
            <p class="text-2xl font-extrabold text-brand-500">{{ $ativos->count() }}</p>
            <p class="text-xs text-gray-400 mt-1 uppercase tracking-wide">Ativos</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 text-center">
            <p class="text-2xl font-extrabold text-green-500">{{ $usados->count() }}</p>
            <p class="text-xs text-gray-400 mt-1 uppercase tracking-wide">Usados</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 text-center">
            <p class="text-2xl font-extrabold text-gray-400">{{ $expirados->count() }}</p>
            <p class="text-xs text-gray-400 mt-1 uppercase tracking-wide">Expirados</p>
        </div>
    </div>

    {{-- Estado vazio --}}
    @if ($userCoupons->isEmpty())
        <div class="text-center py-20">
            <div class="text-6xl mb-4">😕</div>
            <p class="text-gray-500 text-lg font-medium">Você ainda não tem cupons</p>
            <p class="text-gray-400 text-sm mt-1 mb-6">Explore os cupons disponíveis e adicione à sua carteira</p>
            <a href="{{ route('coupons.index') }}"
               class="bg-brand-500 hover:bg-brand-600 text-white font-semibold px-6 py-2.5 rounded-xl transition">
                Explorar Cupons
            </a>
        </div>

    @else

        {{-- Tabs --}}
        <div x-data="{ tab: 'ativos' }" class="space-y-4">

            {{-- Controles das tabs --}}
            <div class="flex gap-2 bg-gray-100 p-1 rounded-xl w-fit">
                @foreach ([['ativos','Ativos',$ativos->count(),'brand-500'], ['usados','Usados',$usados->count(),'green-600'], ['expirados','Expirados',$expirados->count(),'gray-400']] as [$key,$label,$count,$color])
                <button @click="tab = '{{ $key }}'"
                    :class="tab === '{{ $key }}' ? 'bg-white shadow text-gray-800 font-semibold' : 'text-gray-500 hover:text-gray-700'"
                    class="px-4 py-1.5 rounded-lg text-sm transition">
                    {{ $label }}
                    <span class="ml-1 text-xs">({{ $count }})</span>
                </button>
                @endforeach
            </div>

            {{-- Ativos --}}
            <div x-show="tab === 'ativos'" x-cloak>
                @if ($ativos->isEmpty())
                    <p class="text-gray-400 text-sm py-8 text-center">Nenhum cupom ativo no momento.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($ativos as $uc)
                            @include('user.meus-cupons._card', ['userCoupon' => $uc])
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Usados --}}
            <div x-show="tab === 'usados'" x-cloak>
                @if ($usados->isEmpty())
                    <p class="text-gray-400 text-sm py-8 text-center">Nenhum cupom utilizado ainda.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($usados as $uc)
                            @include('user.meus-cupons._card', ['userCoupon' => $uc])
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Expirados --}}
            <div x-show="tab === 'expirados'" x-cloak>
                @if ($expirados->isEmpty())
                    <p class="text-gray-400 text-sm py-8 text-center">Nenhum cupom expirado.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($expirados as $uc)
                            @include('user.meus-cupons._card', ['userCoupon' => $uc])
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    @endif

</div>

{{-- Alpine.js para tabs --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>[x-cloak]{display:none!important}</style>

@endsection
