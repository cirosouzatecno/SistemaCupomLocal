<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\CouponValidation;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponValidationController extends Controller
{
    /** GET /lojista/validar */
    public function showForm()
    {
        return view('merchant.validar.form');
    }

    /** POST /lojista/validar — busca o token e exibe tela de confirmação */
    public function lookup(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string', 'max:100'],
        ], [
            'token.required' => 'Informe o código do cupom.',
        ]);

        $token = trim($request->input('token'));

        /** @var \App\Models\Merchant $merchant */
        $merchant = Auth::guard('merchant')->user();

        // Busca o UserCoupon pelo token e garante que é deste lojista
        $userCoupon = UserCoupon::with(['user', 'coupon', 'merchant'])
            ->where('qr_code_token', $token)
            ->where('merchant_id', $merchant->id)
            ->first();

        if (! $userCoupon) {
            return back()
                ->withInput()
                ->withErrors(['token' => 'Código não encontrado ou não pertence a este comércio.']);
        }

        // Já foi usado
        if ($userCoupon->status === 'used') {
            return back()
                ->withInput()
                ->withErrors(['token' => 'Este cupom já foi utilizado em ' . $userCoupon->used_at?->format('d/m/Y \à\s H:i') . '.']);
        }

        // Expirado pelo status ou pela data do cupom
        if ($userCoupon->status === 'expired') {
            return back()
                ->withInput()
                ->withErrors(['token' => 'Este cupom está expirado.']);
        }

        if (! $userCoupon->coupon->isValid()) {
            return back()
                ->withInput()
                ->withErrors(['token' => 'O cupom está fora do período de validade ou inativo.']);
        }

        return view('merchant.validar.confirm', compact('userCoupon', 'token'));
    }

    /** POST /lojista/validar/confirmar — registra o uso */
    public function confirm(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);

        /** @var \App\Models\Merchant $merchant */
        $merchant = Auth::guard('merchant')->user();

        $userCoupon = UserCoupon::with(['coupon'])
            ->where('qr_code_token', $request->input('token'))
            ->where('merchant_id', $merchant->id)
            ->first();

        if (! $userCoupon) {
            return redirect()->route('merchant.validate.form')
                ->withErrors(['token' => 'Código inválido.']);
        }

        if ($userCoupon->status !== 'active') {
            return redirect()->route('merchant.validate.form')
                ->withErrors(['token' => 'Este cupom não pode mais ser validado (status: ' . $userCoupon->status . ').']);
        }

        // Atualiza o UserCoupon
        $userCoupon->update([
            'status'  => 'used',
            'used_at' => now(),
        ]);

        // Cria o registro de validação
        CouponValidation::create([
            'user_coupon_id' => $userCoupon->id,
            'merchant_id'    => $merchant->id,
            'validated_by'   => $merchant->id,
            'validated_at'   => now(),
        ]);

        return redirect()->route('merchant.validate.form')
            ->with('success', '✅ Cupom "' . $userCoupon->coupon->title . '" validado com sucesso!');
    }
}
