@extends('layouts.app')

@section('title', 'Painel do Lojista')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    {{-- Saudação --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            @if (auth('merchant')->user()->logo_path)
                <img src="{{ asset('storage/' . auth('merchant')->user()->logo_path) }}"
                     alt="Logo" class="h-14 w-14 rounded-xl object-cover border border-gray-200 shadow-sm mb-3">
            @endif
            <h1 class="text-2xl font-bold text-gray-800">Olá, {{ auth('merchant')->user()->name }} 👋</h1>
            <p class="text-sm text-gray-400 mt-1">Aqui está um resumo do seu comércio</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('merchant.coupons.create') }}"
               class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition shadow-sm">
                + Novo cupom
            </a>
            <a href="{{ route('merchant.profile.edit') }}"
               class="border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium px-4 py-2.5 rounded-lg transition">
                Editar perfil
            </a>
        </div>
    </div>

    {{-- Status pendente --}}
    @if (auth('merchant')->user()->status === 'pending')
        <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-xl px-5 py-4 mb-6 text-sm flex items-start gap-3">
            <span class="text-lg">⏳</span>
            <div>
                <strong>Cadastro aguardando aprovação.</strong><br>
                Nossa equipe irá analisar seu cadastro em breve. Você será notificado por e-mail.
            </div>
        </div>
    @endif

    {{-- Cards de estatísticas --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-5 text-center">
            <p class="text-3xl font-bold text-gray-800">{{ $totalCupons }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Total de cupons</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-5 text-center">
            <p class="text-3xl font-bold text-green-600">{{ $totalAtivos }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Cupons ativos</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-5 text-center">
            <p class="text-3xl font-bold text-brand-500">{{ $totalAdicionados }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Adicionados por clientes</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-5 text-center">
            <p class="text-3xl font-bold text-purple-600">{{ $totalValidados }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Validados / usados</p>
        </div>
    </div>

    {{-- Cupons recentes --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-700">Cupons recentes</h2>
            <a href="{{ route('merchant.coupons.index') }}" class="text-sm text-brand-600 hover:underline">Ver todos</a>
        </div>

        @if ($recentCoupons->isEmpty())
            <div class="px-6 py-10 text-center text-gray-400 text-sm">
                Nenhum cupom criado ainda.
                <a href="{{ route('merchant.coupons.create') }}" class="text-brand-600 hover:underline ml-1">Criar agora</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-5 py-3">Cupom</th>
                            <th class="px-5 py-3 text-center">Desconto</th>
                            <th class="px-5 py-3 text-center">Adicionados</th>
                            <th class="px-5 py-3 text-center">Usados</th>
                            <th class="px-5 py-3 text-center">Status</th>
                            <th class="px-5 py-3 text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($recentCoupons as $coupon)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4">
                                <p class="font-medium text-gray-800">{{ $coupon->title }}</p>
                                <p class="text-xs text-gray-400">até {{ $coupon->end_date->format('d/m/Y') }}</p>
                            </td>
                            <td class="px-5 py-4 text-center font-bold text-brand-600">
                                {{ $coupon->formattedDiscount() }}
                            </td>
                            <td class="px-5 py-4 text-center font-semibold text-gray-700">
                                {{ $coupon->user_coupons_count ?? 0 }}
                            </td>
                            <td class="px-5 py-4 text-center font-semibold text-green-600">
                                {{ $coupon->used_count ?? 0 }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if ($coupon->status === 'active')
                                    <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Ativo</span>
                                @elseif ($coupon->status === 'inactive')
                                    <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-0.5 rounded-full">Inativo</span>
                                @else
                                    <span class="bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-0.5 rounded-full">Expirado</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                <a href="{{ route('merchant.coupons.edit', $coupon) }}"
                                   class="text-xs text-brand-600 hover:underline font-medium">Editar</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Atalhos --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('merchant.coupons.create') }}"
           class="flex items-center gap-4 bg-white border border-gray-100 shadow-sm rounded-2xl px-5 py-4 hover:border-brand-300 transition">
            <span class="text-3xl">🏷️</span>
            <div>
                <p class="font-semibold text-gray-700 text-sm">Criar cupom</p>
                <p class="text-xs text-gray-400">Novo desconto</p>
            </div>
        </a>
        <a href="{{ route('merchant.coupons.index') }}"
           class="flex items-center gap-4 bg-white border border-gray-100 shadow-sm rounded-2xl px-5 py-4 hover:border-brand-300 transition">
            <span class="text-3xl">📋</span>
            <div>
                <p class="font-semibold text-gray-700 text-sm">Meus cupons</p>
                <p class="text-xs text-gray-400">Ver e gerenciar</p>
            </div>
        </a>
        <a href="{{ route('merchant.validate.form') }}"
           class="flex items-center gap-4 bg-white border border-gray-100 shadow-sm rounded-2xl px-5 py-4 hover:border-green-300 transition">
            <span class="text-3xl">✅</span>
            <div>
                <p class="font-semibold text-gray-700 text-sm">Validar cupom</p>
                <p class="text-xs text-gray-400">Ler QR do cliente</p>
            </div>
        </a>
        <a href="{{ route('merchant.profile.edit') }}"
           class="flex items-center gap-4 bg-white border border-gray-100 shadow-sm rounded-2xl px-5 py-4 hover:border-brand-300 transition">
            <span class="text-3xl">⚙️</span>
            <div>
                <p class="font-semibold text-gray-700 text-sm">Perfil</p>
                <p class="text-xs text-gray-400">Dados e configurações</p>
            </div>
        </a>
    </div>

</div>
@endsection
