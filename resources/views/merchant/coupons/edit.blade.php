@extends('layouts.app')

@section('title', 'Editar Cupom — Área do Lojista')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">

    <div class="mb-6">
        <a href="{{ route('merchant.coupons.index') }}"
           class="text-sm text-gray-500 hover:text-brand-600 transition flex items-center gap-1 w-fit">
            ← Voltar para meus cupons
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-3">Editar Cupom</h1>
        <p class="text-sm text-gray-400 mt-1">Atualize as informações do cupom</p>
    </div>

    {{-- Estatísticas do cupom --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4 text-center">
            <p class="text-2xl font-bold text-gray-800">{{ $coupon->user_coupons_count ?? $coupon->userCoupons()->count() }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Adicionados</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $coupon->userCoupons()->where('status', 'used')->count() }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Utilizados</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4 text-center">
            <p class="text-2xl font-bold text-yellow-500">{{ $coupon->userCoupons()->where('status', 'active')->count() }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Ativos</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="{{ route('merchant.coupons.update', $coupon) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('merchant.coupons._form', ['coupon' => $coupon])

            <div class="mt-8 flex items-center justify-between">
                {{-- Botão excluir --}}
                <form id="deleteForm" method="POST" action="{{ route('merchant.coupons.destroy', $coupon) }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            onclick="if(confirm('Tem certeza que deseja excluir este cupom?')) document.getElementById('deleteForm').submit()"
                            class="text-sm text-red-500 hover:underline font-medium">
                        Excluir cupom
                    </button>
                </form>

                <div class="flex items-center gap-3">
                    <a href="{{ route('merchant.coupons.index') }}"
                       class="px-5 py-2.5 text-sm text-gray-600 hover:text-gray-800 font-medium transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="bg-brand-500 hover:bg-brand-600 text-white font-semibold text-sm px-6 py-2.5 rounded-lg transition shadow-sm">
                        Salvar alterações
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
