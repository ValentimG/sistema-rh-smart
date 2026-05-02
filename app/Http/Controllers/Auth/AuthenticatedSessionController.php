<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            $funcionario = Auth::user()->funcionario;
            if ($funcionario && $funcionario->isGestor()) {
                return redirect()->route('gestor.dashboard');
            }
            if ($funcionario) {
                return redirect()->route('ponto.index');
            }
        }
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $funcionario = Auth::user()->funcionario;
        if ($funcionario && $funcionario->isGestor()) {
            return redirect()->route('gestor.dashboard');
        }
        if ($funcionario) {
            return redirect()->route('ponto.index');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}