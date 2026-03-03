@extends('layouts.app')

@section('title', $merchant->name . ' — Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    {{-- Cabeçalho --}}
    <div class="mb-6">
        <a href="{{ route('admin.merchants.index') }}"
           class="text-sm text-gray-500 hover:text-brand-600 transition flex items-center gap-1 w-fit">
            ← Voltar para lojistas
        </a>
    </div>

    {{-- Flash --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Cabeçalho do lojista --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6 flex items-start gap-5">
        @if ($merchant->logo_path)
            <img src="{{ asset('storage/' . $merchant->logo_path) }}"
                 class="h-16 w-16 rounded-xl object-cover border border-gray-200 shadow-sm shrink-0" alt="">
        @else
            <div class="h-16 w-16 rounded-xl bg-brand-100 flex items-center justify-center text-brand-600 font-bold text-xl shrink-0">
                {{ strtoupper(substr($merchant->name, 0, 2)) }}
            </div>
        @endif

        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-xl font-bold text-gray-800">{{ $merchant->name }}</h1>
                @if ($merchant->status === 'active')
                    <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Ativo</span>
                @elseif ($merchant->status === 'pending')
                    <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-0.5 rounded-full">Pendente</span>
                @else
                    <span class="bg-red-100 text-red-600 text-xs font-semibold px-2 py-0.5 rounded-full">Bloqueado</span>
                @endif
            </div>
            @if ($merchant->category) <p class="text-sm text-gray-500 mt-0.5">{{ $merchant->category }}</p> @endif
            <p class="text-sm text-gray-400 mt-1">{{ $merchant->email }}</p>
            @if ($merchant->address)
                <p class="text-xs text-gray-400 mt-1">📍 {{ $merchant->address }}{{ $merchant->neighborhood ? ', '.$merchant->neighborhood : '' }}{{ $merchant->city ? ', '.$merchant->city : '' }}{{ $merchant->state ? '/'.$merchant->state : '' }}</p>
            @endif
        </div>

        {{-- Ações --}}
        <div class="flex flex-col gap-2 shrink-0">
            @if ($merchant->status === 'pending')
                <form method="POST" action="{{ route('admin.merchants.approve', $merchant) }}">
                    @csrf
                    <button class="w-full bg-green-500 hover:bg-green-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                        ✅ Aprovar
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.merchants.block', $merchant) }}">
                    @csrf
                    <button class="w-full bg-red-100 hover:bg-red-200 text-red-600 text-sm font-medium px-4 py-2 rounded-lg transition">
                        Bloquear
                    </button>
                </form>
            @elseif ($merchant->status === 'active')
                <form method="POST" action="{{ route('admin.merchants.block', $merchant) }}"
                      onsubmit="return confirm('Bloquear este lojista?')">
                    @csrf
                    <button class="bg-red-100 hover:bg-red-200 text-red-600 text-sm font-medium px-4 py-2 rounded-lg transition">
                        Bloquear
                    </button>
                </form>
            @elseif ($merchant->status === 'blocked')
                <form method="POST" action="{{ route('admin.merchants.reactivate', $merchant) }}">
                    @csrf
                    <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                        Reativar
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4 text-center">
            <p class="text-2xl font-bold text-gray-800">{{ $merchant->coupons_count }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Cupons criados</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4 text-center">
            <p class="text-2xl font-bold text-brand-500">{{ $merchant->user_coupons_count }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Adicionados por clientes</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4 text-center">
            <p class="text-2xl font-bold text-purple-600">
                {{ $merchant->coupons->sum(fn($c) => $c->user_coupons_count) }}
            </p>
            <p class="text-xs text-gray-500 mt-0.5">Usos (via cupons)</p>
        </div>
    </div>

    {{-- Dados adicionais --}}
    @if ($merchant->phone || $merchant->whatsapp || $merchant->cnpj_cpf || $merchant->description)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">Informações</h2>
        <dl class="grid grid-cols-2 gap-3 text-sm">
            @if ($merchant->owner_name)
                <div><dt class="text-xs text-gray-400">Responsável</dt><dd class="font-medium text-gray-700">{{ $merchant->owner_name }}</dd></div>
            @endif
            @if ($merchant->cnpj_cpf)
                <div><dt class="text-xs text-gray-400">CNPJ/CPF</dt><dd class="font-medium text-gray-700">{{ $merchant->cnpj_cpf }}</dd></div>
            @endif
            @if ($merchant->phone)
                <div><dt class="text-xs text-gray-400">Telefone</dt><dd class="font-medium text-gray-700">{{ $merchant->phone }}</dd></div>
            @endif
            @if ($merchant->whatsapp)
                <div><dt class="text-xs text-gray-400">WhatsApp</dt><dd class="font-medium text-gray-700">{{ $merchant->whatsapp }}</dd></div>
            @endif
            <div><dt class="text-xs text-gray-400">Cadastrado em</dt><dd class="font-medium text-gray-700">{{ $merchant->created_at->format('d/m/Y') }}</dd></div>
        </dl>
        @if ($merchant->description)
            <div class="mt-4">
                <p class="text-xs text-gray-400 mb-1">Descrição</p>
                <p class="text-sm text-gray-700">{{ $merchant->description }}</p>
            </div>
        @endif
    </div>
    @endif

    {{-- Cupons recentes --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50">
            <h2 class="text-base font-semibold text-gray-700">Cupons recentes</h2>
        </div>
        @if ($merchant->coupons->isEmpty())
            <div class="px-6 py-8 text-center text-gray-400 text-sm">Nenhum cupom criado.</div>
        @else
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-5 py-3">Título</th>
                        <th class="px-5 py-3 text-center">Desconto</th>
                        <th class="px-5 py-3 text-center">Adicionados</th>
                        <th class="px-5 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($merchant->coupons as $coupon)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            <p class="font-medium text-gray-800">{{ $coupon->title }}</p>
                            <p class="text-xs text-gray-400">até {{ $coupon->end_date->format('d/m/Y') }}</p>
                        </td>
                        <td class="px-5 py-3 text-center font-bold text-brand-600">{{ $coupon->formattedDiscount() }}</td>
                        <td class="px-5 py-3 text-center font-semibold text-gray-700">{{ $coupon->user_coupons_count }}</td>
                        <td class="px-5 py-3 text-center">
                            @if ($coupon->status === 'active')
                                <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Ativo</span>
                            @else
                                <span class="bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-0.5 rounded-full">{{ ucfirst($coupon->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection
