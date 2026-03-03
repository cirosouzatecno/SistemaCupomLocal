<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MerchantAuthController extends Controller
{
    // ─── Registro ─────────────────────────────────────────────────────────────

    public function showRegister()
    {
        return view('auth.merchant.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'owner_name'         => 'required|string|max:255',
            'whatsapp'           => 'required|string|max:20|unique:merchants,whatsapp',
            'email'              => 'required|email|max:255|unique:merchants,email',
            'password'           => 'required|string|min:6|confirmed',
        ], [
            'name.required'      => 'O nome fantasia é obrigatório.',
            'owner_name.required'=> 'O nome do responsável é obrigatório.',
            'whatsapp.required'  => 'O WhatsApp é obrigatório.',
            'whatsapp.unique'    => 'Este WhatsApp já está cadastrado.',
            'email.required'     => 'O e-mail é obrigatório.',
            'email.unique'       => 'Este e-mail já está cadastrado.',
            'password.required'  => 'A senha é obrigatória.',
            'password.min'       => 'A senha deve ter no mínimo 6 caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
        ]);

        $merchant = Merchant::create([
            'name'       => $request->name,
            'owner_name' => $request->owner_name,
            'whatsapp'   => $request->whatsapp,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'status'     => 'pending', // aguarda aprovação do admin
        ]);

        // Não faz login automático — aguarda aprovação do admin.
        return redirect()->route('merchant.login')
                         ->with('success', 'Cadastro enviado! Aguarde a aprovação da plataforma para acessar sua conta.');
    }

    // ─── Login ────────────────────────────────────────────────────────────────

    public function showLogin()
    {
        return view('auth.merchant.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'O e-mail é obrigatório.',
            'email.email'       => 'Informe um e-mail válido.',
            'password.required' => 'A senha é obrigatória.',
        ]);

        $credentials = $request->only('email', 'password');

        if (! Auth::guard('merchant')->attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'E-mail ou senha incorretos.',
            ]);
        }

        /** @var \App\Models\Merchant $merchant */
        $merchant = Auth::guard('merchant')->user();

        if ($merchant->status === 'pending') {
            Auth::guard('merchant')->logout();
            throw ValidationException::withMessages([
                'email' => 'Sua conta ainda está aguardando aprovação.',
            ]);
        }

        if ($merchant->status === 'blocked') {
            Auth::guard('merchant')->logout();
            throw ValidationException::withMessages([
                'email' => 'Sua conta foi bloqueada. Entre em contato com o suporte.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('merchant.dashboard'));
    }

    // ─── Logout ───────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::guard('merchant')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('merchant.login')
                         ->with('success', 'Você saiu com sucesso.');
    }
}
