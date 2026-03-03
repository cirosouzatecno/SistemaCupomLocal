<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAuthController extends Controller
{
    // ─── Registro ─────────────────────────────────────────────────────────────

    public function showRegister()
    {
        return view('auth.user.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'whatsapp'              => 'required|string|max:20|unique:users,whatsapp',
            'password'              => 'required|string|min:6|confirmed',
        ], [
            'name.required'         => 'O nome é obrigatório.',
            'whatsapp.required'     => 'O WhatsApp é obrigatório.',
            'whatsapp.unique'       => 'Este WhatsApp já está cadastrado.',
            'password.required'     => 'A senha é obrigatória.',
            'password.min'          => 'A senha deve ter no mínimo 6 caracteres.',
            'password.confirmed'    => 'As senhas não conferem.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('web')->login($user);

        return redirect()->route('user.dashboard')
                         ->with('success', 'Cadastro realizado com sucesso! Bem-vindo(a), ' . $user->name . '.');
    }

    // ─── Login ────────────────────────────────────────────────────────────────

    public function showLogin(Request $request)
    {
        // Armazena URL de retorno (ex.: vindo de cupons/{id}) para usar após login
        if ($request->filled('redirect')) {
            session()->put('url.intended', $request->redirect);
        }

        return view('auth.user.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required|string',
            'password' => 'required|string',
        ], [
            'whatsapp.required' => 'O WhatsApp é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
        ]);

        $credentials = [
            'whatsapp' => $request->whatsapp,
            'password' => $request->password,
        ];

        if (! Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'whatsapp' => 'WhatsApp ou senha incorretos.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('user.dashboard'));
    }

    // ─── Logout ───────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login')
                         ->with('success', 'Você saiu com sucesso.');
    }
}
