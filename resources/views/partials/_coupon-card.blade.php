{{--
    Partial: _coupon-card.blade.php
    Uso: @include('partials._coupon-card', ['coupon' => $coupon])
--}}
<a href="{{ route('coupons.show', $coupon) }}"
   class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-200 flex flex-col">

    {{-- Imagem --}}
    <div class="relative h-36 bg-brand-50 overflow-hidden">
        @if ($coupon->image_path)
            <img src="{{ asset('storage/' . $coupon->image_path) }}"
                 alt="{{ $coupon->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center text-5xl">🏷️</div>
        @endif

        {{-- Badge de desconto --}}
        <span class="absolute top-2 right-2 bg-brand-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">
            {{ $coupon->formattedDiscount() }} OFF
        </span>
    </div>

    {{-- Conteúdo --}}
    <div class="p-4 flex flex-col flex-1">
        {{-- Loja --}}
        <div class="flex items-center gap-2 mb-1">
            @if ($coupon->merchant->logo_path)
                <img src="{{ asset('storage/' . $coupon->merchant->logo_path) }}"
                     alt="{{ $coupon->merchant->name }}"
                     class="w-5 h-5 rounded-full object-cover">
            @endif
            <span class="text-xs text-gray-400 truncate">{{ $coupon->merchant->name }}</span>
        </div>

        <h3 class="font-semibold text-gray-800 text-sm leading-tight mb-1 line-clamp-2 group-hover:text-brand-600 transition">
            {{ $coupon->title }}
        </h3>

        @if ($coupon->description)
            <p class="text-xs text-gray-500 line-clamp-2 flex-1">{{ $coupon->description }}</p>
        @endif

        {{-- Rodapé do card --}}
        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
            @if ($coupon->merchant->neighborhood)
                <span>📍 {{ $coupon->merchant->neighborhood }}</span>
            @endif
            <span>Válido até {{ $coupon->end_date->format('d/m/Y') }}</span>
        </div>
    </div>
</a>
