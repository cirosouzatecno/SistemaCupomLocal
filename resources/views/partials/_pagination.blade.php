@if ($paginator->hasPages())
<nav class="flex items-center gap-1 flex-wrap justify-center" aria-label="Navegação de páginas">

    {{-- Anterior --}}
    @if ($paginator->onFirstPage())
        <span class="px-3 py-2 rounded-lg text-gray-300 text-sm cursor-not-allowed select-none">← Anterior</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="px-3 py-2 rounded-lg border border-gray-200 text-gray-600 text-sm hover:bg-gray-50 transition">
            ← Anterior
        </a>
    @endif

    {{-- Páginas --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="px-2 text-gray-400">…</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="px-3 py-2 rounded-lg bg-brand-500 text-white text-sm font-semibold shadow-sm">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}"
                       class="px-3 py-2 rounded-lg border border-gray-200 text-gray-600 text-sm hover:bg-gray-50 transition">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Próxima --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="px-3 py-2 rounded-lg border border-gray-200 text-gray-600 text-sm hover:bg-gray-50 transition">
            Próxima →
        </a>
    @else
        <span class="px-3 py-2 rounded-lg text-gray-300 text-sm cursor-not-allowed select-none">Próxima →</span>
    @endif

</nav>
@endif
