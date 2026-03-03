@extends('layouts.app')

@section('title', 'Validar Cupom — Área do Lojista')

@section('content')
<div class="max-w-lg mx-auto px-4 py-14">

    {{-- Cabeçalho --}}
    <div class="text-center mb-8">
        <div class="text-6xl mb-4">📱</div>
        <h1 class="text-2xl font-bold text-gray-800">Validar Cupom</h1>
        <p class="text-sm text-gray-500 mt-2">
            Digite ou cole o código exibido no aplicativo do cliente.<br>
            Você também pode copiar o código do QR exibido na tela.
        </p>
    </div>

    {{-- Sucesso --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-300 text-green-800 rounded-xl px-5 py-4 mb-6 text-sm font-medium flex items-center gap-3">
            <span class="text-xl">✅</span>
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulário --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="{{ route('merchant.validate.lookup') }}">
            @csrf

            <div>
                <label for="token" class="block text-sm font-semibold text-gray-700 mb-2">
                    Código do cupom
                </label>
                <textarea
                    name="token"
                    id="token"
                    rows="3"
                    autofocus
                    placeholder="Cole aqui o código UUID do cupom do cliente..."
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-brand-400 resize-none
                           @error('token') border-red-400 bg-red-50 @enderror"
                >{{ old('token') }}</textarea>

                @error('token')
                    <p class="text-red-500 text-sm mt-2 font-medium flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror

                <p class="text-xs text-gray-400 mt-2">
                    O código aparece abaixo do QR Code na tela do cliente. Ex: <span class="font-mono">550e8400-e29b-41d4-a716-446655440000</span>
                </p>
            </div>

            <button type="submit"
                    class="mt-6 w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 rounded-xl transition shadow-sm text-sm">
                Verificar cupom →
            </button>
        </form>
    </div>

    {{-- Instruções --}}
    <div class="mt-8 bg-blue-50 border border-blue-100 rounded-2xl px-6 py-5">
        <h3 class="text-sm font-semibold text-blue-800 mb-3">Como validar um cupom</h3>
        <ol class="text-sm text-blue-700 space-y-2 list-decimal list-inside">
            <li>Peça ao cliente para abrir o cupom no aplicativo</li>
            <li>O QR Code será exibido — copie ou anote o código abaixo dele</li>
            <li>Cole o código no campo acima e clique em <strong>Verificar</strong></li>
            <li>Confirme as informações do cupom e clique em <strong>Confirmar uso</strong></li>
        </ol>
    </div>

</div>
@endsection
