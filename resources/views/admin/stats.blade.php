@extends('layouts.app')

@section('title', 'Estatísticas — Painel Admin')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    {{-- Cabeçalho --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">📊 Estatísticas da Plataforma</h1>
            <p class="text-sm text-gray-400 mt-1">Visão geral de uso e crescimento</p>
        </div>
        <a href="{{ route('admin.dashboard') }}"
           class="text-sm text-gray-500 hover:text-brand-600 transition">← Painel</a>
    </div>

    {{-- Cards totais --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-5 text-center">
            <p class="text-3xl font-bold text-gray-800">{{ number_format($totals['users']) }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Usuários</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-5 text-center">
            <p class="text-3xl font-bold text-green-600">{{ number_format($totals['merchants']) }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Lojistas ativos</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-5 text-center">
            <p class="text-3xl font-bold text-brand-500">{{ number_format($totals['coupons']) }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Cupons cadastrados</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-5 text-center">
            <p class="text-3xl font-bold text-purple-600">{{ number_format($totals['validations']) }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Validações totais</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        {{-- Novos usuários por mês --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-semibold text-gray-700 mb-5">👤 Novos usuários — últimos 6 meses</h2>
            @php $maxUsers = $newUsers->max() ?: 1; @endphp
            <div class="space-y-3">
                @foreach ($months as $month)
                    @php
                        $count = $newUsers->get($month, 0);
                        $pct   = round(($count / $maxUsers) * 100);
                        $label = \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('M/Y');
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>{{ $label }}</span>
                            <span class="font-semibold">{{ $count }}</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-brand-400 rounded-full transition-all"
                                 style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Validações por mês --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-semibold text-gray-700 mb-5">✅ Validações — últimos 6 meses</h2>
            @php $maxVal = $validationsByMonth->max() ?: 1; @endphp
            <div class="space-y-3">
                @foreach ($months as $month)
                    @php
                        $count = $validationsByMonth->get($month, 0);
                        $pct   = round(($count / $maxVal) * 100);
                        $label = \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('M/Y');
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>{{ $label }}</span>
                            <span class="font-semibold">{{ $count }}</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-400 rounded-full transition-all"
                                 style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        {{-- Top cupons mais adicionados --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <h2 class="text-base font-semibold text-gray-700">🏷️ Cupons mais adicionados</h2>
            </div>
            @if ($topCoupons->isEmpty())
                <div class="px-6 py-8 text-center text-gray-400 text-sm">Nenhum dado disponível.</div>
            @else
                @php $maxCoupon = $topCoupons->first()->user_coupons_count ?: 1; @endphp
                <ul class="divide-y divide-gray-50">
                    @foreach ($topCoupons as $i => $coupon)
                    <li class="px-6 py-3">
                        <div class="flex items-center justify-between mb-1">
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-gray-400 mr-2">#{{ $i + 1 }}</span>
                                <span class="text-sm font-medium text-gray-800">{{ $coupon->title }}</span>
                                <p class="text-xs text-gray-400 ml-5">{{ $coupon->merchant->name ?? '—' }}</p>
                            </div>
                            <span class="text-sm font-bold text-brand-600 shrink-0 ml-3">
                                {{ $coupon->user_coupons_count }}
                            </span>
                        </div>
                        <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden ml-5">
                            <div class="h-full bg-brand-300 rounded-full"
                                 style="width: {{ round(($coupon->user_coupons_count / $maxCoupon) * 100) }}%"></div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Top lojistas com mais validações --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <h2 class="text-base font-semibold text-gray-700">🏪 Lojistas com mais validações</h2>
            </div>
            @if ($topMerchants->isEmpty())
                <div class="px-6 py-8 text-center text-gray-400 text-sm">Nenhum dado disponível.</div>
            @else
                @php $maxMerchant = $topMerchants->first()->coupon_validations_count ?: 1; @endphp
                <ul class="divide-y divide-gray-50">
                    @foreach ($topMerchants as $i => $m)
                    <li class="px-6 py-3">
                        <div class="flex items-center justify-between mb-1">
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-gray-400 mr-2">#{{ $i + 1 }}</span>
                                <span class="text-sm font-medium text-gray-800">{{ $m->name }}</span>
                                @if ($m->city)
                                    <p class="text-xs text-gray-400 ml-5">{{ $m->city }}{{ $m->state ? '/'.$m->state : '' }}</p>
                                @endif
                            </div>
                            <span class="text-sm font-bold text-purple-600 shrink-0 ml-3">
                                {{ $m->coupon_validations_count }}
                            </span>
                        </div>
                        <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden ml-5">
                            <div class="h-full bg-purple-300 rounded-full"
                                 style="width: {{ round(($m->coupon_validations_count / $maxMerchant) * 100) }}%"></div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>

    {{-- Cupons por categoria --}}
    @if ($byCategory->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-base font-semibold text-gray-700 mb-5">🗂️ Cupons por categoria</h2>
        @php $maxCat = $byCategory->first()->total ?: 1; @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-3">
            @foreach ($byCategory as $cat)
            <div>
                <div class="flex justify-between text-xs text-gray-600 mb-1">
                    <span>{{ $cat->category ?? 'Sem categoria' }}</span>
                    <span class="font-semibold">{{ $cat->total }}</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-green-400 rounded-full"
                         style="width: {{ round(($cat->total / $maxCat) * 100) }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
