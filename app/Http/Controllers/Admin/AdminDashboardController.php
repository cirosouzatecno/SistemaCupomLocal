<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponValidation;
use App\Models\Merchant;
use App\Models\User;
use App\Models\UserCoupon;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        $stats = [
            'users'            => User::count(),
            'merchantsTotal'   => Merchant::count(),
            'merchantsPending' => Merchant::where('status', 'pending')->count(),
            'merchantsActive'  => Merchant::where('status', 'active')->count(),
            'couponsActive'    => Coupon::where('status', 'active')->count(),
            'userCoupons'      => UserCoupon::count(),
            'validations'      => CouponValidation::count(),
        ];

        $pendingMerchants = Merchant::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentValidations = CouponValidation::with(['merchant:id,name', 'userCoupon.coupon:id,title', 'userCoupon.user:id,name'])
            ->orderBy('validated_at', 'desc')
            ->take(8)
            ->get();

        return view('admin.dashboard', compact('admin', 'stats', 'pendingMerchants', 'recentValidations'));
    }
}
