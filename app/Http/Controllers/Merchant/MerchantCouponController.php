<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MerchantCouponController extends Controller
{
    private function merchant()
    {
        return Auth::guard('merchant')->user();
    }

    // ─── Listagem ─────────────────────────────────────────────────────────────

    public function index()
    {
        $merchant = $this->merchant();

        $coupons = Coupon::where('merchant_id', $merchant->id)
            ->withCount([
                'userCoupons as total_adicionados',
                'userCoupons as total_usados' => fn ($q) => $q->where('status', 'used'),
            ])
            ->latest()
            ->paginate(15);

        return view('merchant.coupons.index', compact('coupons', 'merchant'));
    }

    // ─── Criar ────────────────────────────────────────────────────────────────

    public function create()
    {
        return view('merchant.coupons.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string|max:1000',
            'category'       => 'nullable|string|max:100',
            'discount_type'  => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0.01|max:999999',
            'min_value'      => 'nullable|numeric|min:0',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'total_quantity' => 'nullable|integer|min:1',
            'per_user_limit' => 'required|integer|min:1|max:10',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'         => 'required|in:active,inactive',
        ], $this->messages());

        $merchant = $this->merchant();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('coupons', 'public');
        }

        Coupon::create([
            'merchant_id'    => $merchant->id,
            'title'          => $data['title'],
            'description'    => $data['description'] ?? null,
            'category'       => $data['category'] ?? null,
            'discount_type'  => $data['discount_type'],
            'discount_value' => $data['discount_value'],
            'min_value'      => $data['min_value'] ?? null,
            'start_date'     => $data['start_date'],
            'end_date'       => $data['end_date'],
            'total_quantity' => $data['total_quantity'] ?? null,
            'per_user_limit' => $data['per_user_limit'],
            'image_path'     => $imagePath,
            'status'         => $data['status'],
        ]);

        return redirect()->route('merchant.coupons.index')
            ->with('success', 'Cupom "' . $data['title'] . '" criado com sucesso!');
    }

    // ─── Editar ───────────────────────────────────────────────────────────────

    public function edit(Coupon $coupon)
    {
        $this->authorizeOwnership($coupon);

        $stats = [
            'adicionados' => UserCoupon::where('coupon_id', $coupon->id)->count(),
            'usados'      => UserCoupon::where('coupon_id', $coupon->id)->where('status', 'used')->count(),
            'ativos'      => UserCoupon::where('coupon_id', $coupon->id)->where('status', 'active')->count(),
        ];

        return view('merchant.coupons.edit', compact('coupon', 'stats'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $this->authorizeOwnership($coupon);

        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string|max:1000',
            'category'       => 'nullable|string|max:100',
            'discount_type'  => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0.01|max:999999',
            'min_value'      => 'nullable|numeric|min:0',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'total_quantity' => 'nullable|integer|min:1',
            'per_user_limit' => 'required|integer|min:1|max:10',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'         => 'required|in:active,inactive,expired',
        ], $this->messages());

        // Substitui imagem se enviada nova
        if ($request->hasFile('image')) {
            if ($coupon->image_path) {
                Storage::disk('public')->delete($coupon->image_path);
            }
            $data['image_path'] = $request->file('image')->store('coupons', 'public');
        }

        $coupon->update([
            'title'          => $data['title'],
            'description'    => $data['description'] ?? null,
            'category'       => $data['category'] ?? null,
            'discount_type'  => $data['discount_type'],
            'discount_value' => $data['discount_value'],
            'min_value'      => $data['min_value'] ?? null,
            'start_date'     => $data['start_date'],
            'end_date'       => $data['end_date'],
            'total_quantity' => $data['total_quantity'] ?? null,
            'per_user_limit' => $data['per_user_limit'],
            'image_path'     => $data['image_path'] ?? $coupon->image_path,
            'status'         => $data['status'],
        ]);

        return redirect()->route('merchant.coupons.index')
            ->with('success', 'Cupom "' . $coupon->title . '" atualizado com sucesso!');
    }

    // ─── Excluir ──────────────────────────────────────────────────────────────

    public function destroy(Coupon $coupon)
    {
        $this->authorizeOwnership($coupon);

        // Não permite excluir se houver usuários com o cupom
        $totalVinculos = UserCoupon::where('coupon_id', $coupon->id)->count();
        if ($totalVinculos > 0) {
            return back()->with('error',
                'Não é possível excluir: ' . $totalVinculos . ' usuário(s) já adicionaram este cupom. Inative-o em vez disso.'
            );
        }

        if ($coupon->image_path) {
            Storage::disk('public')->delete($coupon->image_path);
        }

        $coupon->delete();

        return redirect()->route('merchant.coupons.index')
            ->with('success', 'Cupom excluído com sucesso.');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function authorizeOwnership(Coupon $coupon): void
    {
        abort_if($coupon->merchant_id !== $this->merchant()->id, 403, 'Acesso negado.');
    }

    private function messages(): array
    {
        return [
            'title.required'          => 'O título é obrigatório.',
            'discount_type.required'  => 'Selecione o tipo de desconto.',
            'discount_type.in'        => 'Tipo de desconto inválido.',
            'discount_value.required' => 'O valor do desconto é obrigatório.',
            'discount_value.min'      => 'O desconto deve ser maior que zero.',
            'start_date.required'     => 'A data de início é obrigatória.',
            'end_date.required'       => 'A data de término é obrigatória.',
            'end_date.after_or_equal' => 'A data de término deve ser igual ou posterior à data de início.',
            'per_user_limit.required' => 'O limite por usuário é obrigatório.',
            'image.image'             => 'O arquivo deve ser uma imagem.',
            'image.max'               => 'A imagem deve ter no máximo 2 MB.',
            'status.required'         => 'Selecione o status.',
        ];
    }
}
