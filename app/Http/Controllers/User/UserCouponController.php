<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserCouponController extends Controller
{
    /**
     * Lista todos os cupons do usuário logado.
     */
    public function index()
    {
        $userCoupons = UserCoupon::with(['coupon.merchant'])
            ->where('user_id', Auth::guard('web')->id())
            ->latest()
            ->get();

        // Marca automaticamente como expired cupons vencidos
        $userCoupons->each(function (UserCoupon $uc) {
            if ($uc->status === 'active' && $uc->coupon->end_date->lt(now()->startOfDay())) {
                $uc->update(['status' => 'expired']);
                $uc->status = 'expired';
            }
        });

        $ativos   = $userCoupons->where('status', 'active');
        $usados   = $userCoupons->where('status', 'used');
        $expirados = $userCoupons->where('status', 'expired');

        return view('user.meus-cupons.index', compact('userCoupons', 'ativos', 'usados', 'expirados'));
    }

    /**
     * Adiciona um cupom à carteira do usuário.
     */
    public function store(Request $request, Coupon $coupon)
    {
        $userId = Auth::guard('web')->id();

        // ── 1. Cupom deve estar ativo e dentro da validade ─────────────────
        abort_if(
            $coupon->status !== 'active'
            || $coupon->start_date->gt(now())
            || $coupon->end_date->lt(now()->startOfDay()),
            403,
            'Este cupom não está disponível.'
        );

        // ── 2. Respeitamos per_user_limit ──────────────────────────────────
        $qtdJaAdicionada = UserCoupon::where('user_id', $userId)
            ->where('coupon_id', $coupon->id)
            ->count();

        if ($qtdJaAdicionada >= $coupon->per_user_limit) {
            return redirect()->route('coupons.show', $coupon)
                ->with('error', 'Você já adicionou o limite deste cupom.');
        }

        // ── 3. Verifica quantidade total disponível ────────────────────────
        if ($coupon->total_quantity !== null) {
            $totalUsados = UserCoupon::where('coupon_id', $coupon->id)->count();
            if ($totalUsados >= $coupon->total_quantity) {
                return redirect()->route('coupons.show', $coupon)
                    ->with('error', 'Este cupom atingiu o limite total de resgates.');
            }
        }

        // ── 4. Cria o registro (QR é gerado ao visualizar pela 1ª vez) ─────
        UserCoupon::create([
            'user_id'     => $userId,
            'coupon_id'   => $coupon->id,
            'merchant_id' => $coupon->merchant_id,
            'status'      => 'active',
        ]);

        return redirect()->route('user.meus-cupons')
            ->with('success', 'Cupom "' . $coupon->title . '" adicionado com sucesso! 🎉');
    }

    /**
     * Exibe o detalhe de um user_coupon com QR Code.
     * Gera o qr_code_token na primeira vez que o usuário abre o cupom.
     */
    public function show(UserCoupon $userCoupon)
    {
        // Garante que o cupom pertence ao usuário logado
        abort_if($userCoupon->user_id !== Auth::guard('web')->id(), 403);

        $userCoupon->load(['coupon.merchant', 'user']);

        // ── Gera QR token na primeira abertura ─────────────────────────────
        if (is_null($userCoupon->qr_code_token)) {
            $userCoupon->update([
                'qr_code_token' => Str::uuid()->toString(),
                'generated_at'  => now(),
            ]);
        }

        // ── Marca como expired se o cupom já venceu ────────────────────────
        if ($userCoupon->status === 'active'
            && $userCoupon->coupon->end_date->lt(now()->startOfDay())) {
            $userCoupon->update(['status' => 'expired']);
        }

        // ── Gera SVG do QR Code (conteúdo = token UUID) ───────────────────
        $qrCode = null;
        if ($userCoupon->status !== 'expired') {
            $qrCode = QrCode::format('svg')
                ->size(280)
                ->errorCorrection('H')
                ->generate($userCoupon->qr_code_token);
        }

        return view('user.meus-cupons.show', compact('userCoupon', 'qrCode'));
    }
}
