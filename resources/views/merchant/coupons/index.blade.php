@extends('layouts.app')

@section('title', 'Meus Cupons — Área do Lojista')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    {{-- Cabeçalho --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">🏷️ Meus Cupons</h1>
            <p class="text-sm text-gray-400 mt-1">Gerencie os cupons do seu comércio</p>
        </div>
        <a href="{{ route('merchant.coupons.create') }}"
           class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition shadow-sm">
            + Novo cupom
        </a>
    </div>

    {{-- Alertas flash --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
            {{ session('error') }}
        </div>
    @endif

    @if ($coupons->isEmpty())
        <div class="text-center py-20">
            <div class="text-6xl mb-4">🏷️</div>
            <p class="text-gray-500 font-medium">Você ainda não criou nenhum cupom.</p>
            <a href="{{ route('merchant.coupons.create') }}"
               class="mt-4 inline-block bg-brand-500 hover:bg-brand-600 text-white font-semibold px-6 py-2.5 rounded-xl transition">
                Criar meu primeiro cupom
            </a>
        </div>
    @else
        {{-- Tabela --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wide">
                        <tr>
                            <th class="px-5 py-3">Cupom</th>
                            <th class="px-5 py-3 text-center">Desconto</th>
                            <th class="px-5 py-3 text-center">Validade</th>
                            <th class="px-5 py-3 text-center">Adicionados</th>
                            <th class="px-5 py-3 text-center">Usados</th>
                            <th class="px-5 py-3 text-center">Status</th>
                            <th class="px-5 py-3 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($coupons as $coupon)
                        <tr class="hover:bg-gray-50 transition">
                            {{-- Título + categoria --}}
                            <td class="px-5 py-4">
                                <p class="font-medium text-gray-800">{{ $coupon->title }}</p>
                                @if ($coupon->category)
                                    <span class="text-xs text-gray-400">{{ $coupon->category }}</span>
                                @endif
                            </td>

                            {{-- Desconto --}}
                            <td class="px-5 py-4 text-center">
                                <span class="font-bold text-brand-600">{{ $coupon->formattedDiscount() }}</span>
                            </td>

                            {{-- Validade --}}
                            <td class="px-5 py-4 text-center text-gray-500 whitespace-nowrap">
                                {{ $coupon->start_date->format('d/m/Y') }}<br>
                                <span class="text-xs">até {{ $coupon->end_date->format('d/m/Y') }}</span>
                            </td>

                            {{-- Adicionados --}}
                            <td class="px-5 py-4 text-center font-semibold text-gray-700">
                                {{ $coupon->total_adicionados ?? 0 }}
                            </td>

                            {{-- Usados --}}
                            <td class="px-5 py-4 text-center font-semibold text-green-600">
                                {{ $coupon->total_usados ?? 0 }}
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4 text-center">
                                @if ($coupon->status === 'active')
                                    <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Ativo</span>
                                @elseif ($coupon->status === 'inactive')
                                    <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-0.5 rounded-full">Inativo</span>
                                @else
                                    <span class="bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-0.5 rounded-full">Expirado</span>
                                @endif
                            </td>

                            {{-- Ações --}}
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('merchant.coupons.edit', $coupon) }}"
                                       class="text-xs text-brand-600 hover:underline font-medium">Editar</a>

                                    <form method="POST" action="{{ route('merchant.coupons.destroy', $coupon) }}"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este cupom?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs text-red-500 hover:underline font-medium">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            @if ($coupons->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $coupons->links('partials._pagination') }}
                </div>
            @endif
        </div>
    @endif

</div>
@endsection
