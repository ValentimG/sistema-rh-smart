<?php

namespace App\Http\Controllers;

use App\Models\EventoCalendario;
use App\Models\Funcionario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarioController extends Controller
{
    private function funcionarioLogado(): Funcionario
    {
        return Funcionario::where('user_id', auth()->id())->firstOrFail();
    }

    public function index(): View
    {
        $funcionario = $this->funcionarioLogado();
        $isGestor = $funcionario->isGestor();

        return view('calendario.index', compact('funcionario', 'isGestor'));
    }

    public function eventos(Request $request): JsonResponse
    {
        $funcionario = $this->funcionarioLogado();
        $isGestor = $funcionario->isGestor();

        $query = EventoCalendario::where(function ($q) use ($funcionario, $isGestor) {
            // Eventos visiveis para todos (criados pelo gestor)
            $q->where('visivel_todos', true);
            // OU eventos pessoais deste funcionario
            $q->orWhere('funcionario_id', $funcionario->id);
        });

        if ($request->filled('start') && $request->filled('end')) {
            $query->whereBetween('data', [$request->start, $request->end]);
        }

        $eventos = $query->get()->map(function ($e) use ($funcionario) {
            $cor = match ($e->tipo) {
                'feriado' => '#ef4444',
                'evento_empresa' => '#2563eb',
                default => $e->funcionario_id === $funcionario->id ? '#10b981' : '#f59e0b',
            };

            return [
                'id' => $e->id,
                'title' => $e->titulo,
                'start' => $e->data->format('Y-m-d'),
                'allDay' => true,
                'backgroundColor' => $cor,
                'borderColor' => $cor,
                'textColor' => '#fff',
                'extendedProps' => [
                    'descricao' => $e->descricao,
                    'tipo' => $e->tipo,
                    'pessoal' => $e->funcionario_id === $funcionario->id,
                ]
            ];
        });

        return response()->json($eventos);
    }

    public function store(Request $request): JsonResponse
    {
        $funcionario = $this->funcionarioLogado();
        $isGestor = $funcionario->isGestor();

        $request->validate([
            'data' => 'required|date',
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'tipo' => 'required|in:pessoal,feriado,evento_empresa',
        ]);

        $visivelTodos = $isGestor && in_array($request->tipo, ['feriado', 'evento_empresa']);

        $evento = EventoCalendario::create([
            'funcionario_id' => $funcionario->id,
            'data' => $request->data,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'tipo' => $request->tipo,
            'visivel_todos' => $visivelTodos,
        ]);

        return response()->json(['sucesso' => true, 'evento' => $evento]);
    }

    public function destroy(EventoCalendario $evento): JsonResponse
    {
        $funcionario = $this->funcionarioLogado();

        // So pode excluir se for o dono ou gestor
        if ($evento->funcionario_id !== $funcionario->id && !$funcionario->isGestor()) {
            return response()->json(['erro' => 'Acesso negado.'], 403);
        }

        $evento->delete();

        return response()->json(['sucesso' => true]);
    }
}