@extends('layouts.app')

@section('title', 'Cadastro Lojista — Cupons Locais')

@section('content')
<div class="flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-lg">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Cadastre seu comércio</h1>
            <p class="text-gray-500 mt-2">Preencha os dados básicos para solicitar acesso à plataforma</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">

            @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('merchant.register.post') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nome fantasia <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Ex.: Padaria do João"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('name') border-red-400 @enderror"
                            required autofocus
                        >
                    </div>

                    <div>
                        <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Responsável <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="owner_name"
                            name="owner_name"
                            value="{{ old('owner_name') }}"
                            placeholder="Nome do dono"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('owner_name') border-red-400 @enderror"
                            required
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">
                            WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="whatsapp"
                            name="whatsapp"
                            value="{{ old('whatsapp') }}"
                            placeholder="(00) 00000-0000"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('whatsapp') border-red-400 @enderror"
                            required
                        >
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            E-mail <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="contato@comercio.com"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('email') border-red-400 @enderror"
                            required
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Senha <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Mínimo 6 caracteres"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500"
                            required
                        >
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Confirmar senha <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Repita a senha"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500"
                            required
                        >
                    </div>
                </div>

                <p class="text-xs text-gray-400">
                    Após o cadastro, sua conta ficará em análise até ser aprovada pela plataforma.
                </p>

                <button type="submit"
                    class="w-full bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 rounded-lg transition duration-200">
                    Enviar cadastro
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Já tem conta?
                <a href="{{ route('merchant.login') }}" class="text-brand-600 font-semibold hover:underline">Entrar</a>
            </p>

        </div>
    </div>
</div>
@endsection
