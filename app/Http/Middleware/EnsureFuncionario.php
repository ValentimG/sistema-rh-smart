<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFuncionario
{
    /**
     * Permite acesso apenas a usuários vinculados a um funcionário (qualquer tipo).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $funcionario = $request->user()?->funcionario;

        if (! $funcionario) {
            abort(403, 'Seu usuário não está vinculado a nenhum funcionário.');
        }

        return $next($request);
    }
}
