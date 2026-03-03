<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    /**
     * Página inicial — lista cupons ativos com filtros.
     */
    public function home(Request $request)
    {
        $query = Coupon::with('merchant')
            ->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->whereHas('merchant', fn ($q) => $q->where('status', 'active'));

        // ── Filtro: categoria ──────────────────────────────────────────────
        if ($request->filled('categoria')) {
            $query->where('category', $request->categoria);
        }

        // ── Filtro: bairro (via merchant) ──────────────────────────────────
        if ($request->filled('bairro')) {
            $query->whereHas('merchant', function ($q) use ($request) {
                $q->where('neighborhood', 'like', '%' . $request->bairro . '%');
            });
        }

        // ── Filtro: busca por título / loja ────────────────────────────────
        if ($request->filled('busca')) {
            $termo = $request->busca;
            $query->where(function ($q) use ($termo) {
                $q->where('title', 'like', "%{$termo}%")
                  ->orWhere('description', 'like', "%{$termo}%")
                  ->orWhereHas('merchant', fn ($m) => $m->where('name', 'like', "%{$termo}%"));
            });
        }

        $coupons = $query->latest()->paginate(12)->withQueryString();

        // Valores únicos para os selects de filtro
        $categories = Coupon::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        $neighborhoods = \App\Models\Merchant::select('neighborhood')
            ->where('status', 'active')
            ->whereNotNull('neighborhood')
            ->distinct()
            ->pluck('neighborhood')
            ->sort()
            ->values();

        return view('public.home', compact('coupons', 'categories', 'neighborhoods'));
    }

    /**
     * Listagem completa de cupons (rota /cupons).
     */
    public function index(Request $request)
    {
        return $this->home($request);
    }

    /**
     * Detalhe de um cupom específico.
     */
    public function show(Request $request, Coupon $coupon)
    {
        // Cupom deve ser público (ativo e dentro da validade)
        abort_if(
            $coupon->status !== 'active'
            || $coupon->start_date->gt(now())
            || $coupon->end_date->lt(now()->startOfDay()),
            404
        );

        $coupon->load('merchant');

        // Verifica se o usuário logado já adicionou esse cupom
        $jaAdicionado = false;
        if (Auth::guard('web')->check()) {
            $jaAdicionado = $coupon->userCoupons()
                ->where('user_id', Auth::guard('web')->id())
                ->exists();
        }

        // Outros cupons do mesmo lojista
        $outroCupons = Coupon::where('merchant_id', $coupon->merchant_id)
            ->where('id', '!=', $coupon->id)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now())
            ->limit(4)
            ->get();

        return view('public.coupon', compact('coupon', 'jaAdicionado', 'outroCupons'));
    }
}
