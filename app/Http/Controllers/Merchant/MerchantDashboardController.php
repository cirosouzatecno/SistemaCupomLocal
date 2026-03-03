<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\UserCoupon;
use Illuminate\Support\Facades\Auth;

class MerchantDashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\Merchant $merchant */
        $merchant   = Auth::guard('merchant')->user();
        $merchantId = $merchant->id;

        $totalCupons     = Coupon::where('merchant_id', $merchantId)->count();
        $totalAtivos     = Coupon::where('merchant_id', $merchantId)->where('status', 'active')->count();
        $totalAdicionados = UserCoupon::where('merchant_id', $merchantId)->count();
        $totalValidados  = UserCoupon::where('merchant_id', $merchantId)->where('status', 'used')->count();

        // Últimos 5 cupons mais recentes
        $recentCoupons = Coupon::where('merchant_id', $merchantId)
            ->withCount([
                'userCoupons as total_adicionados',
                'userCoupons as total_usados' => fn ($q) => $q->where('status', 'used'),
            ])
            ->latest()
            ->limit(5)
            ->get();

        return view('merchant.dashboard', compact(
            'merchant',
            'totalCupons',
            'totalAtivos',
            'totalAdicionados',
            'totalValidados',
            'recentCoupons'
        ));
    }
}
