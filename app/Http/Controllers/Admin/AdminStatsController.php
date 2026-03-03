<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponValidation;
use App\Models\Merchant;
use App\Models\User;
use App\Models\UserCoupon;
use Illuminate\Support\Facades\DB;

class AdminStatsController extends Controller
{
    /** GET /admin/estatisticas */
    public function index()
    {
        // Totais gerais
        $totals = [
            'users'       => User::count(),
            'merchants'   => Merchant::where('status', 'active')->count(),
            'coupons'     => Coupon::count(),
            'validations' => CouponValidation::count(),
        ];

        // Novos usuários por mês (últimos 6 meses)
        $newUsers = User::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Validações por mês (últimos 6 meses)
        $validationsByMonth = CouponValidation::select(
                DB::raw("DATE_FORMAT(validated_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->where('validated_at', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Cupons mais adicionados (top 10)
        $topCoupons = Coupon::withCount('userCoupons')
            ->with('merchant:id,name')
            ->orderByDesc('user_coupons_count')
            ->take(10)
            ->get();

        // Lojistas com mais validações (top 10)
        $topMerchants = Merchant::select('merchants.*')
            ->withCount('couponValidations')
            ->where('status', 'active')
            ->orderByDesc('coupon_validations_count')
            ->take(10)
            ->get();

        // Cupons por categoria
        $byCategory = Coupon::select('category', DB::raw('COUNT(*) as total'))
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(8)
            ->get();

        // Gerar labels dos últimos 6 meses
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }

        return view('admin.stats', compact(
            'totals',
            'newUsers',
            'validationsByMonth',
            'topCoupons',
            'topMerchants',
            'byCategory',
            'months'
        ));
    }
}
