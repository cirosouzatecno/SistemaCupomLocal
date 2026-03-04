@props([
    'title' => 'Tema Azul Escuro',
    'bodyClass' => '',
    'mainClass' => '',
    'withSidebar' => true,
])

<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    {{-- Anti-FOSC (tema claro/escuro) --}}
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

    @vite(['resources/css/theme.css', 'resources/js/theme-demo.js'])
    @stack('head')
</head>
<body class="min-h-screen antialiased {{ $bodyClass }}">

<div class="min-h-screen flex bg-bg text-text">
    @if ($withSidebar)
        <aside
            data-theme-sidebar
            class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full bg-surface border-r border-border-strong shadow-soft-2 transition lg:static lg:translate-x-0"
        >
            @if (isset($sidebar))
                {{ $sidebar }}
            @else
                <x-theme.sidebar />
            @endif
        </aside>

        <div data-sidebar-overlay class="fixed inset-0 z-30 bg-slate-900/40 hidden lg:hidden"></div>
    @endif

    <div class="flex min-h-screen flex-1 flex-col">
        <header class="sticky top-0 z-20 border-b border-border bg-surface backdrop-blur">
            @if (isset($header))
                {{ $header }}
            @else
                <x-theme.header />
            @endif
        </header>

        <main class="flex-1 {{ $mainClass }}">
            {{ $slot }}
        </main>

        <footer class="border-t border-border bg-surface">
            @if (isset($footer))
                {{ $footer }}
            @else
                <x-theme.footer />
            @endif
        </footer>
    </div>
</div>

@stack('scripts')
</body>
</html>
