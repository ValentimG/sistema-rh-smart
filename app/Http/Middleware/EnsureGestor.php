<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureGestor
{
    /**
     * Permite acesso apenas a usuários vinculados a um funcionário do tipo 'gestor'.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $funcionario = $request->user()?->funcionario;

        if (! $funcionario || ! $funcionario->isGestor()) {
            abort(403, 'Acesso exclusivo para gestores.');
        }

        return $next($request);
    }
}
