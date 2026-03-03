@extends('layouts.app')

@section('title', 'Lojistas — Painel Admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">

    {{-- Cabeçalho --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">🏪 Lojistas</h1>
            <p class="text-sm text-gray-400 mt-1">Gerencie o cadastro e status dos lojistas</p>
        </div>
        <a href="{{ route('admin.dashboard') }}"
           class="text-sm text-gray-500 hover:text-brand-600 transition">← Painel</a>
    </div>

    {{-- Flash --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filtros de status --}}
    <div class="flex flex-wrap items-center gap-3 mb-6">
        @php
            $statuses = [
                ''        => ['label' => 'Todos',     'count' => $counts['total']],
                'pending' => ['label' => 'Pendentes', 'count' => $counts['pending']],
                'active'  => ['label' => 'Ativos',    'count' => $counts['active']],
                'blocked' => ['label' => 'Bloqueados','count' => $counts['blocked']],
            ];
            $current = request('status', '');
        @endphp

        @foreach ($statuses as $val => $info)
            <a href="{{ route('admin.merchants.index', array_filter(['status' => $val, 'q' => request('q')])) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium transition border
                      {{ $current === $val
                            ? 'bg-brand-500 text-white border-brand-500'
                            : 'bg-white text-gray-600 border-gray-200 hover:border-brand-300' }}">
                {{ $info['label'] }}
                <span class="ml-1 opacity-70">({{ $info['count'] }})</span>
            </a>
        @endforeach

        {{-- Busca --}}
        <form method="GET" action="{{ route('admin.merchants.index') }}" class="ml-auto flex items-center gap-2">
            @if (request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Buscar por nome, e-mail ou CNPJ..."
                   class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-brand-400">
            <button type="submit"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm px-3 py-1.5 rounded-lg transition">
                Buscar
            </button>
        </form>
    </div>

    {{-- Tabela --}}
    @if ($merchants->isEmpty())
        <div class="text-center py-20 text-gray-400 text-sm">Nenhum lojista encontrado.</div>
    @else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3">Lojista</th>
                        <th class="px-5 py-3">E-mail</th>
                        <th class="px-5 py-3 text-center">Cupons</th>
                        <th class="px-5 py-3 text-center">Adicionados</th>
                        <th class="px-5 py-3 text-center">Cadastro</th>
                        <th class="px-5 py-3 text-center">Status</th>
                        <th class="px-5 py-3 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($merchants as $merchant)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                @if ($merchant->logo_path)
                                    <img src="{{ asset('storage/' . $merchant->logo_path) }}"
                                         class="h-8 w-8 rounded-lg object-cover border border-gray-200" alt="">
                                @else
                                    <div class="h-8 w-8 rounded-lg bg-brand-100 flex items-center justify-center text-brand-600 font-bold text-xs">
                                        {{ strtoupper(substr($merchant->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $merchant->name }}</p>
                                    @if ($merchant->city)
                                        <p class="text-xs text-gray-400">{{ $merchant->city }}{{ $merchant->state ? ', '.$merchant->state : '' }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-600 text-xs">{{ $merchant->email }}</td>
                        <td class="px-5 py-4 text-center font-semibold text-gray-700">{{ $merchant->coupons_count }}</td>
                        <td class="px-5 py-4 text-center font-semibold text-brand-600">{{ $merchant->user_coupons_count }}</td>
                        <td class="px-5 py-4 text-center text-xs text-gray-500">{{ $merchant->created_at->format('d/m/Y') }}</td>
                        <td class="px-5 py-4 text-center">
                            @if ($merchant->status === 'active')
                                <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Ativo</span>
                            @elseif ($merchant->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-0.5 rounded-full">Pendente</span>
                            @else
                                <span class="bg-red-100 text-red-600 text-xs font-semibold px-2 py-0.5 rounded-full">Bloqueado</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.merchants.show', $merchant) }}"
                                   class="text-xs text-brand-600 hover:underline font-medium px-2">Ver</a>

                                @if ($merchant->status === 'pending' || $merchant->status === 'blocked')
                                    <form method="POST" action="{{ route('admin.merchants.approve', $merchant) }}">
                                        @csrf
                                        <button class="text-xs text-green-600 hover:underline font-medium px-2">Aprovar</button>
                                    </form>
                                @endif

                                @if ($merchant->status === 'active')
                                    <form method="POST" action="{{ route('admin.merchants.block', $merchant) }}"
                                          onsubmit="return confirm('Bloquear {{ addslashes($merchant->name) }}?')">
                                        @csrf
                                        <button class="text-xs text-red-500 hover:underline font-medium px-2">Bloquear</button>
                                    </form>
                                @endif

                                @if ($merchant->status === 'blocked')
                                    <form method="POST" action="{{ route('admin.merchants.reactivate', $merchant) }}">
                                        @csrf
                                        <button class="text-xs text-blue-500 hover:underline font-medium px-2">Reativar</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($merchants->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $merchants->links('partials._pagination') }}
            </div>
        @endif
    </div>
    @endif

</div>
@endsection
