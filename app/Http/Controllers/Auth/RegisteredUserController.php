<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Funcionario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo' => ['required', 'in:funcionario,gestor'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Funcionario::create([
            'user_id' => $user->id,
            'nome' => $request->name,
            'email' => $request->email,
            'cpf' => '000.000.000-' . str_pad($user->id, 2, '0', STR_PAD_LEFT),
            'endereco' => 'A DEFINIR',
            'cargo' => $request->tipo === 'gestor' ? 'Gestor' : 'A definir',
            'data_admissao' => now(),
            'tipo' => $request->tipo,
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($request->tipo === 'funcionario') {
            return redirect()->route('perfil.completar');
        }

        return redirect()->route('gestor.dashboard');
    }
}