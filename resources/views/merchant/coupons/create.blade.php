@extends('layouts.app')

@section('title', 'Novo Cupom — Área do Lojista')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">

    <div class="mb-6">
        <a href="{{ route('merchant.coupons.index') }}"
           class="text-sm text-gray-500 hover:text-brand-600 transition flex items-center gap-1 w-fit">
            ← Voltar para meus cupons
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-3">Novo Cupom</h1>
        <p class="text-sm text-gray-400 mt-1">Preencha os campos abaixo para criar um cupom</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="{{ route('merchant.coupons.store') }}" enctype="multipart/form-data">
            @csrf
            @include('merchant.coupons._form')

            <div class="mt-8 flex items-center justify-end gap-3">
                <a href="{{ route('merchant.coupons.index') }}"
                   class="px-5 py-2.5 text-sm text-gray-600 hover:text-gray-800 font-medium transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-brand-500 hover:bg-brand-600 text-white font-semibold text-sm px-6 py-2.5 rounded-lg transition shadow-sm">
                    Criar Cupom
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
