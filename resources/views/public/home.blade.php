@extends('layouts.app')

@section('title', 'Cupons de Desconto na sua Cidade — Cupons Locais')

@section('content')

{{-- ─── Hero ──────────────────────────────────────────────────────────────── --}}
<section class="bg-gradient-to-br from-brand-500 to-orange-400 text-white py-14 px-4">
    <div class="max-w-3xl mx-auto text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight mb-3">
            Economize no comércio local! 🎉
        </h1>
        <p class="text-orange-100 text-lg mb-8">
            Cupons exclusivos de lojas e restaurantes perto de você.
        </p>

        {{-- Busca rápida --}}
        <form method="GET" action="{{ route('coupons.index') }}"
              class="flex gap-2 max-w-xl mx-auto">
            <input
                type="text"
                name="busca"
                value="{{ request('busca') }}"
                placeholder="Buscar cupom, loja ou categoria…"
                class="flex-1 rounded-xl px-4 py-3 text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white shadow-sm"
            >
            <button type="submit"
                    class="bg-white text-brand-600 font-semibold px-5 py-3 rounded-xl hover:bg-orange-50 transition shadow-sm">
                Buscar
            </button>
        </form>
    </div>
</section>

{{-- ─── Filtros + Listagem ──────────────────────────────────────────────────── --}}
<section class="max-w-6xl mx-auto px-4 py-10">

    {{-- Filtros --}}
    <form method="GET" action="{{ route('coupons.index') }}"
          class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-8 flex flex-wrap gap-3 items-end">

        {{-- Categoria --}}
        <div class="flex flex-col gap-1 flex-1 min-w-[150px]">
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Categoria</label>
            <select name="categoria"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option value="">Todas</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" @selected(request('categoria') === $cat)>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Bairro --}}
        <div class="flex flex-col gap-1 flex-1 min-w-[150px]">
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Bairro</label>
            <select name="bairro"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option value="">Todos</option>
                @foreach ($neighborhoods as $nb)
                    <option value="{{ $nb }}" @selected(request('bairro') === $nb)>
                        {{ $nb }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit"
                    class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-5 py-2 rounded-lg transition">
                Filtrar
            </button>
            @if (request()->hasAny(['categoria','bairro','busca']))
                <a href="{{ route('home') }}"
                   class="border border-gray-200 text-gray-500 hover:bg-gray-50 text-sm font-medium px-4 py-2 rounded-lg transition">
                    Limpar
                </a>
            @endif
        </div>
    </form>

    {{-- Cabeçalho da listagem --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            @if (request()->hasAny(['categoria','bairro','busca']))
                Resultados da busca
            @else
                Cupons em destaque
            @endif
        </h2>
        <span class="text-sm text-gray-400">
            {{ $coupons->total() }} {{ Str::plural('cupom', $coupons->total()) }} encontrado(s)
        </span>
    </div>

    {{-- Grid de cupons --}}
    @if ($coupons->isEmpty())
        <div class="text-center py-20">
            <div class="text-5xl mb-4">😔</div>
            <p class="text-gray-500 text-lg">Nenhum cupom encontrado para os filtros selecionados.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block text-brand-600 hover:underline text-sm">
                Ver todos os cupons
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach ($coupons as $coupon)
                @include('partials._coupon-card', ['coupon' => $coupon])
            @endforeach
        </div>

        {{-- Paginação --}}
        @if ($coupons->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $coupons->links('partials._pagination') }}
            </div>
        @endif
    @endif

</section>

{{-- ─── CTA para lojistas ───────────────────────────────────────────────────── --}}
<section class="bg-gray-800 text-white py-12 px-4">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-2xl font-bold mb-2">Você é comerciante? 🏪</h2>
        <p class="text-gray-300 mb-6">
            Cadastre seu negócio e comece a publicar cupons para atrair mais clientes.
        </p>
        <a href="{{ route('merchant.register') }}"
           class="bg-brand-500 hover:bg-brand-600 text-white font-semibold px-8 py-3 rounded-xl transition shadow">
            Quero cadastrar meu comércio
        </a>
    </div>
</section>

@endsection
