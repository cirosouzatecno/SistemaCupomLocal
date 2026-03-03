<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cupons Locais')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#fff7ed',
                            100: '#ffeed5',
                            500: '#f97316',
                            600: '#ea6c0a',
                            700: '#c2570a',
                        }
                    }
                }
            }
        }
    </script>
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
