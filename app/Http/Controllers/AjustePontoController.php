<?php

namespace App\Http\Controllers;

use App\Models\AjustePonto;
use App\Models\Funcionario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AjustePontoController extends Controller
{
    private function funcionarioLogado(): Funcionario
    {
        return Funcionario::where('user_id', auth()->id())->firstOrFail();
    }

    public function index(): View
    {
        $funcionario = $this->funcionarioLogado();
        $isGestor = $funcionario->isGestor();

        $query = AjustePonto::with(['funcionario', 'aprovador'])->orderByDesc('created_at');

        if (! $isGestor) {
            $query->where('funcionario_id', $funcionario->id);
        }

        $ajustes = $query->paginate(10);

        return view('ajustes.index', compact('ajustes', 'funcionario', 'isGestor'));
    }

    public function create(): View
    {
        $funcionario = $this->funcionarioLogado();
        return view('ajustes.create', compact('funcionario'));
    }

    public function store(Request $request): RedirectResponse
    {
        $funcionario = $this->funcionarioLogado();

        $validated = $request->validate([
            'data' => ['required', 'date', 'before_or_equal:today'],
            'tipo' => ['required', 'in:entrada,saida_almoco,volta_almoco,saida'],
            'horario_solicitado' => ['required'],
            'motivo' => ['required', 'string', 'max:500'],
        ]);

        AjustePonto::create([
            'funcionario_id' => $funcionario->id,
            'data' => $validated['data'],
            'tipo' => $validated['tipo'],
            'horario_solicitado' => $validated['horario_solicitado'],
            'motivo' => $validated['motivo'],
            'status' => 'pendente',
        ]);

        return redirect()->route('ajustes.index')
            ->with('success', 'Solicitacao de ajuste enviada com sucesso.');
    }

    public function aprovar(AjustePonto $ajuste): RedirectResponse
    {
        $funcionario = $this->funcionarioLogado();
        abort_unless($funcionario->isGestor(), 403);

        $ajuste->update([
            'status' => 'aprovado',
            'aprovado_por' => $funcionario->id,
        ]);

        return back()->with('success', 'Ajuste aprovado com sucesso.');
    }

    public function reprovar(AjustePonto $ajuste): RedirectResponse
    {
        $funcionario = $this->funcionarioLogado();
        abort_unless($funcionario->isGestor(), 403);

        $ajuste->update(['status' => 'reprovado']);

        return back()->with('success', 'Ajuste reprovado.');
    }
}