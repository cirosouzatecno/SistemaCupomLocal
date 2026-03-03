@extends('layouts.app')

@section('title', 'Login — Cupons Locais')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Entrar na conta</h1>
            <p class="text-gray-500 mt-2">Use seu WhatsApp e senha para acessar</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">

            {{-- Erros de validação --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('user.login.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">
                        WhatsApp
                    </label>
                    <input
                        type="text"
                        id="whatsapp"
                        name="whatsapp"
                        value="{{ old('whatsapp') }}"
                        placeholder="(00) 00000-0000"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('whatsapp') border-red-400 @enderror"
                        required autofocus
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Senha
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500"
                        required
                    >
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded">
                        Lembrar de mim
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 rounded-lg transition duration-200">
                    Entrar
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Não tem conta?
                <a href="{{ route('user.register') }}" class="text-brand-600 font-semibold hover:underline">
                    Cadastre-se gratuitamente
                </a>
            </p>

            <p class="text-center text-xs text-gray-400 mt-4">
                É lojista?
                <a href="{{ route('merchant.login') }}" class="text-gray-500 hover:underline">
                    Acesse a área do comerciante
                </a>
            </p>

        </div>
    </div>
</div>
@endsection
