<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserCoupon;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user   = Auth::guard('web')->user();
        $userId = $user->id;

        $totalAtivos   = UserCoupon::where('user_id', $userId)->where('status', 'active')->count();
        $totalUsados   = UserCoupon::where('user_id', $userId)->where('status', 'used')->count();
        $totalExpirados = UserCoupon::where('user_id', $userId)->where('status', 'expired')->count();

        // Últimos 4 cupons adicionados
        $recentCoupons = UserCoupon::with(['coupon.merchant'])
            ->where('user_id', $userId)
            ->latest()
            ->limit(4)
            ->get();

        return view('user.dashboard', compact(
            'user', 'totalAtivos', 'totalUsados', 'totalExpirados', 'recentCoupons'
        ));
    }
}
