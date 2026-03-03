@extends('layouts.app')

@section('title', 'Painel Administrativo')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    {{-- Cabeçalho --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Painel Administrativo 🛡️</h1>
            <p class="text-sm text-gray-400 mt-1">Bem-vindo(a), <strong>{{ $admin->name }}</strong></p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.merchants.index') }}"
               class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition shadow-sm">
                Gerenciar lojistas
            </a>
            <a href="{{ route('admin.stats') }}"
               class="border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium px-4 py-2.5 rounded-lg transition">
                Estatísticas
            </a>
        </div>
    </div>

    {{-- Cards de stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-5 text-center">
            <p class="text-3xl font-bold text-gray-800">{{ $stats['users'] }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Usuários cadastrados</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-5 text-center">
            <p class="text-3xl font-bold text-green-600">{{ $stats['merchantsActive'] }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Lojistas ativos</p>
            @if ($stats['merchantsPending'] > 0)
                <span class="inline-block mt-1 bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-0.5 rounded-full">
                    {{ $stats['merchantsPending'] }} pendente{{ $stats['merchantsPending'] > 1 ? 's' : '' }}
                </span>
            @endif
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-5 text-center">
            <p class="text-3xl font-bold text-brand-500">{{ $stats['couponsActive'] }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Cupons ativos</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-5 text-center">
            <p class="text-3xl font-bold text-purple-600">{{ $stats['validations'] }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Validações realizadas</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Lojistas pendentes --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-700">⏳ Lojistas pendentes</h2>
                <a href="{{ route('admin.merchants.index', ['status' => 'pending']) }}"
                   class="text-sm text-brand-600 hover:underline">Ver todos</a>
            </div>

            @if ($pendingMerchants->isEmpty())
                <div class="px-6 py-8 text-center text-gray-400 text-sm">
                    Nenhum lojista aguardando aprovação 🎉
                </div>
            @else
                <ul class="divide-y divide-gray-50">
                    @foreach ($pendingMerchants as $m)
                    <li class="px-6 py-4 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $m->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $m->email }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $m->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex gap-2 shrink-0">
                            <form method="POST" action="{{ route('admin.merchants.approve', $m) }}">
                                @csrf
                                <button class="bg-green-100 hover:bg-green-200 text-green-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    Aprovar
                                </button>
                            </form>
                            <a href="{{ route('admin.merchants.show', $m) }}"
                               class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                Ver
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Validações recentes --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-700">✅ Validações recentes</h2>
                <a href="{{ route('admin.stats') }}" class="text-sm text-brand-600 hover:underline">Estatísticas</a>
            </div>

            @if ($recentValidations->isEmpty())
                <div class="px-6 py-8 text-center text-gray-400 text-sm">
                    Nenhuma validação registrada ainda.
                </div>
            @else
                <ul class="divide-y divide-gray-50">
                    @foreach ($recentValidations as $v)
                    <li class="px-6 py-3">
                        <p class="text-sm font-medium text-gray-800">
                            {{ $v->userCoupon?->coupon?->title ?? '—' }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $v->merchant?->name ?? '—' }} ·
                            {{ $v->validated_at?->format('d/m/Y H:i') }}
                        </p>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>

</div>
@endsection
