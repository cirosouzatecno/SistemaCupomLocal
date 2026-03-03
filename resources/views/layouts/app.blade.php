<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cupons Locais')</title>

    {{-- ── Anti-FOSC: aplica classe `dark` ANTES do primeiro render ──────── --}}
    {{-- Fallback inline para navegadores sem suporte a módulos ES              --}}
    <script>
        (function () {
            var k = 'cupons-theme', d = false;
            try {
                var s = localStorage.getItem(k);
                if (s !== null) { d = s === 'dark'; }
                else { d = window.matchMedia('(prefers-color-scheme: dark)').matches; }
            } catch (e) {
                var c = document.cookie.split(';')
                    .find(function (x) { return x.trim().indexOf(k + '=') === 0; });
                d = c ? c.split('=')[1].trim() === 'dark'
                      : window.matchMedia('(prefers-color-scheme: dark)').matches;
            }
            if (d) document.documentElement.classList.add('dark');
            document.documentElement.setAttribute('data-theme', d ? 'dark' : 'light');
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="bg-brand-500 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">
                🏷️ Cupons Locais
            </a>
            <div class="flex items-center gap-4 text-sm">
                @php
                    $isUser     = auth('web')->check();
                    $isMerchant = auth('merchant')->check();
                    $isAdmin    = auth('admin')->check();
                @endphp

                @if ($isAdmin)
                    <span class="hidden sm:inline opacity-75">🛡️ Admin</span>
                    <a href="{{ route('admin.dashboard') }}" class="hover:underline">Painel</a>
                    <a href="{{ route('admin.merchants.index') }}" class="hover:underline hidden sm:inline">Lojistas</a>
                    <a href="{{ route('admin.stats') }}" class="hover:underline hidden sm:inline">Stats</a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button class="hover:underline">Sair</button>
                    </form>
                @elseif ($isUser)
                    <a href="{{ route('coupons.index') }}" class="hidden sm:inline hover:underline">
                        Explorar Cupons
                    </a>
                    <span class="hidden sm:inline">Olá, {{ auth('web')->user()->name }}</span>
                    <a href="{{ route('user.meus-cupons') }}" class="hover:underline">Meus Cupons</a>
                    <form method="POST" action="{{ route('user.logout') }}" class="inline">
                        @csrf
                        <button class="hover:underline">Sair</button>
                    </form>
                @elseif ($isMerchant)
                    <span class="hidden sm:inline">{{ auth('merchant')->user()->name }}</span>
                    <a href="{{ route('merchant.dashboard') }}" class="hover:underline">Painel</a>
                    <a href="{{ route('merchant.validate.form') }}" class="hover:underline hidden sm:inline">Validar</a>
                    <form method="POST" action="{{ route('merchant.logout') }}" class="inline">
                        @csrf
                        <button class="hover:underline">Sair</button>
                    </form>
                @else
                    <a href="{{ route('coupons.index') }}" class="hidden sm:inline hover:underline">
                        Explorar Cupons
                    </a>
                    <a href="{{ route('user.login') }}" class="hover:underline">Entrar</a>
                    <a href="{{ route('user.register') }}"
                       class="bg-white text-brand-600 font-semibold px-3 py-1 rounded-lg hover:bg-gray-100 transition">
                        Cadastrar
                    </a>
                @endif

                {{-- ── Botão de tema claro/escuro ─────────────────────────── --}}
                <button
                    data-theme-toggle
                    aria-label="Alternar tema"
                    title="Alternar tema claro/escuro"
                    class="ml-2 flex items-center gap-1 rounded-lg px-2 py-1 text-sm font-medium
                           bg-white/10 hover:bg-white/20 transition focus:outline-none focus:ring-2 focus:ring-white/50"
                >
                    <span data-theme-icon aria-hidden="true">🌙</span>
                    <span data-theme-label class="sr-only">Modo escuro</span>
                </button>
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="max-w-6xl mx-auto mt-4 px-4">
            <div class="bg-green-100 border border-green-400 text-green-800 rounded-lg px-4 py-3">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-6xl mx-auto mt-4 px-4">
            <div class="bg-red-100 border border-red-400 text-red-800 rounded-lg px-4 py-3">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Conteúdo principal --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Rodapé --}}
    <footer class="bg-gray-800 text-gray-400 text-center text-xs py-4 mt-8">
        &copy; {{ date('Y') }} Cupons Locais — Todos os direitos reservados.
    </footer>

</body>
</html>
