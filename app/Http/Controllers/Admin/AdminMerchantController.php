<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;

class AdminMerchantController extends Controller
{
    /** GET /admin/lojistas */
    public function index(Request $request)
    {
        $query = Merchant::withCount(['coupons', 'userCoupons'])
            ->orderByRaw("FIELD(status, 'pending', 'active', 'blocked')")
            ->orderBy('created_at', 'desc');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cnpj_cpf', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $merchants = $query->paginate(20)->withQueryString();

        $counts = [
            'total'   => Merchant::count(),
            'pending' => Merchant::where('status', 'pending')->count(),
            'active'  => Merchant::where('status', 'active')->count(),
            'blocked' => Merchant::where('status', 'blocked')->count(),
        ];

        return view('admin.merchants.index', compact('merchants', 'counts'));
    }

    /** GET /admin/lojistas/{merchant} */
    public function show(Merchant $merchant)
    {
        $merchant->loadCount(['coupons', 'userCoupons'])
                 ->load(['coupons' => fn($q) => $q->withCount('userCoupons')->latest()->take(10)]);

        return view('admin.merchants.show', compact('merchant'));
    }

    /** POST /admin/lojistas/{merchant}/aprovar */
    public function approve(Merchant $merchant)
    {
        $merchant->update(['status' => 'active']);

        return back()->with('success', "Lojista \"{$merchant->name}\" aprovado com sucesso.");
    }

    /** POST /admin/lojistas/{merchant}/bloquear */
    public function block(Merchant $merchant)
    {
        $merchant->update(['status' => 'blocked']);

        return back()->with('success', "Lojista \"{$merchant->name}\" foi bloqueado.");
    }

    /** POST /admin/lojistas/{merchant}/reativar */
    public function reactivate(Merchant $merchant)
    {
        $merchant->update(['status' => 'active']);

        return back()->with('success', "Lojista \"{$merchant->name}\" reativado.");
    }
}
