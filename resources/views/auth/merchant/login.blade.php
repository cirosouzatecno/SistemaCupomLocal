@extends('layouts.app')

@section('title', 'Login Lojista — Cupons Locais')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Área do Lojista</h1>
            <p class="text-gray-500 mt-2">Acesse com seu e-mail e senha</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">

            @if (session('success'))
                <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('merchant.login.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="seunome@email.com"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('email') border-red-400 @enderror"
                        required autofocus
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500"
                        required
                    >
                </div>

                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" id="remember" class="rounded">
                    <label for="remember" class="cursor-pointer">Lembrar de mim</label>
                </div>

                <button type="submit"
                    class="w-full bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 rounded-lg transition duration-200">
                    Entrar
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Não tem cadastro?
                <a href="{{ route('merchant.register') }}" class="text-brand-600 font-semibold hover:underline">
                    Registre seu comércio
                </a>
            </p>

            <p class="text-center text-xs text-gray-400 mt-4">
                É cliente?
                <a href="{{ route('user.login') }}" class="text-gray-500 hover:underline">
                    Acesse a área do consumidor
                </a>
            </p>

        </div>
    </div>
</div>
@endsection
