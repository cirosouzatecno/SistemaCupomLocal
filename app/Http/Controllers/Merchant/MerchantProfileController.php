<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MerchantProfileController extends Controller
{
    public function edit()
    {
        $merchant = Auth::guard('merchant')->user();

        return view('merchant.profile.edit', compact('merchant'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\Merchant $merchant */
        $merchant = Auth::guard('merchant')->user();

        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'owner_name'   => 'required|string|max:255',
            'cnpj_cpf'     => 'nullable|string|max:20',
            'address'      => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:100',
            'city'         => 'nullable|string|max:100',
            'state'        => 'nullable|string|max:2',
            'zip_code'     => 'nullable|string|max:10',
            'phone'        => 'nullable|string|max:20',
            'whatsapp'     => 'required|string|max:20|unique:merchants,whatsapp,' . $merchant->id,
            'email'        => 'required|email|max:255|unique:merchants,email,' . $merchant->id,
            'category'     => 'nullable|string|max:100',
            'description'  => 'nullable|string|max:2000',
            'website'      => 'nullable|url|max:255',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password'     => 'nullable|string|min:6|confirmed',
        ], [
            'name.required'       => 'O nome fantasia é obrigatório.',
            'owner_name.required' => 'O nome do responsável é obrigatório.',
            'whatsapp.required'   => 'O WhatsApp é obrigatório.',
            'whatsapp.unique'     => 'Este WhatsApp já está em uso por outra conta.',
            'email.required'      => 'O e-mail é obrigatório.',
            'email.unique'        => 'Este e-mail já está em uso por outra conta.',
            'logo.image'          => 'O arquivo deve ser uma imagem.',
            'logo.max'            => 'A logo deve ter no máximo 1 MB.',
            'password.min'        => 'A nova senha deve ter no mínimo 6 caracteres.',
            'password.confirmed'  => 'As senhas não conferem.',
        ]);

        // Logo
        if ($request->hasFile('logo')) {
            if ($merchant->logo_path) {
                Storage::disk('public')->delete($merchant->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        // Nova senha (opcional)
        $updateData = [
            'name'         => $data['name'],
            'owner_name'   => $data['owner_name'],
            'cnpj_cpf'     => $data['cnpj_cpf'] ?? null,
            'address'      => $data['address'] ?? null,
            'neighborhood' => $data['neighborhood'] ?? null,
            'city'         => $data['city'] ?? null,
            'state'        => $data['state'] ?? null,
            'zip_code'     => $data['zip_code'] ?? null,
            'phone'        => $data['phone'] ?? null,
            'whatsapp'     => $data['whatsapp'],
            'email'        => $data['email'],
            'category'     => $data['category'] ?? null,
            'description'  => $data['description'] ?? null,
            'website'      => $data['website'] ?? null,
        ];

        if (isset($data['logo_path'])) {
            $updateData['logo_path'] = $data['logo_path'];
        }

        if (! empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $merchant->update($updateData);

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }
}
