{{--
    Partial: user/meus-cupons/_card.blade.php
    Uso: @include('user.meus-cupons._card', ['userCoupon' => $uc])
--}}
<a href="{{ route('user.meus-cupons.show', $userCoupon) }}"
   class="group bg-white rounded-2xl border shadow-sm overflow-hidden flex items-stretch hover:shadow-md transition duration-200
          {{ $userCoupon->status === 'used' ? 'opacity-60' : '' }}
          {{ $userCoupon->status === 'expired' ? 'opacity-50' : '' }}">

    {{-- Faixa lateral colorida por status --}}
    <div class="w-2 flex-shrink-0
        {{ $userCoupon->status === 'active' ? 'bg-brand-500' : '' }}
        {{ $userCoupon->status === 'used'   ? 'bg-green-500' : '' }}
        {{ $userCoupon->status === 'expired'? 'bg-gray-300'  : '' }}">
    </div>

    <div class="p-4 flex flex-col flex-1 gap-1">
        {{-- Badge de status + desconto --}}
        <div class="flex items-center justify-between mb-1">
            <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                {{ $userCoupon->status === 'active'  ? 'bg-brand-100 text-brand-700' : '' }}
                {{ $userCoupon->status === 'used'    ? 'bg-green-100 text-green-700' : '' }}
                {{ $userCoupon->status === 'expired' ? 'bg-gray-100 text-gray-500'  : '' }}">
                @if ($userCoupon->status === 'active')  ✅ Ativo
                @elseif ($userCoupon->status === 'used') ✔️ Utilizado
                @else 🔒 Expirado
                @endif
            </span>
            <span class="text-sm font-bold text-brand-600">
                {{ $userCoupon->coupon->formattedDiscount() }} OFF
            </span>
        </div>

        <h3 class="font-semibold text-gray-800 text-sm leading-tight group-hover:text-brand-600 transition">
            {{ $userCoupon->coupon->title }}
        </h3>

        <p class="text-xs text-gray-400">{{ $userCoupon->coupon->merchant->name }}</p>

        <div class="flex items-center justify-between mt-2 text-xs text-gray-400">
            <span>
                @if ($userCoupon->status === 'used' && $userCoupon->used_at)
                    Usado em {{ $userCoupon->used_at->format('d/m/Y') }}
                @else
                    Válido até {{ $userCoupon->coupon->end_date->format('d/m/Y') }}
                @endif
            </span>
            @if ($userCoupon->status === 'active')
                <span class="text-brand-500 font-medium">Ver QR Code →</span>
            @endif
        </div>
    </div>
</a>
