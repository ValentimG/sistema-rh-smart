<?php

namespace App\Http\Controllers;

use App\Models\Ferias;
use App\Models\Funcionario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeriasController extends Controller
{
    private function funcionarioLogado(): Funcionario
    {
        return Funcionario::where('user_id', auth()->id())->firstOrFail();
    }

    public function index(): View
    {
        $funcionario = $this->funcionarioLogado();
        $isGestor = $funcionario->isGestor();

        $query = Ferias::with(['funcionario', 'aprovador'])->orderByDesc('created_at');

        if (! $isGestor) {
            $query->where('funcionario_id', $funcionario->id);
        }

        $ferias = $query->paginate(10);

        return view('ferias.index', compact('ferias', 'funcionario', 'isGestor'));
    }

    public function create(): View
    {
        $funcionario = $this->funcionarioLogado();
        return view('ferias.create', compact('funcionario'));
    }

    public function store(Request $request): RedirectResponse
    {
        $funcionario = $this->funcionarioLogado();

        $validated = $request->validate([
            'data_inicio' => ['required', 'date', 'after_or_equal:today'],
            'data_fim' => ['required', 'date', 'after_or_equal:data_inicio'],
            'observacao' => ['nullable', 'string', 'max:500'],
        ]);

        $dias = \Carbon\Carbon::parse($validated['data_inicio'])
            ->diffInDays(\Carbon\Carbon::parse($validated['data_fim'])) + 1;

        Ferias::create([
            'funcionario_id' => $funcionario->id,
            'data_inicio' => $validated['data_inicio'],
            'data_fim' => $validated['data_fim'],
            'dias' => $dias,
            'observacao' => $validated['observacao'] ?? null,
            'status' => 'pendente',
        ]);

        return redirect()->route('ferias.index')
            ->with('success', 'Solicitacao de ferias enviada com sucesso.');
    }

    public function show(Ferias $feria): View
    {
        $funcionario = $this->funcionarioLogado();
        $isGestor = $funcionario->isGestor();

        if (! $isGestor && $feria->funcionario_id !== $funcionario->id) {
            abort(403);
        }

        return view('ferias.show', compact('feria', 'isGestor'));
    }

    public function aprovar(Ferias $feria): RedirectResponse
    {
        $funcionario = $this->funcionarioLogado();
        abort_unless($funcionario->isGestor(), 403);

        $feria->update([
            'status' => 'aprovado',
            'aprovado_por' => $funcionario->id,
            'aprovado_em' => now(),
        ]);

        return back()->with('success', 'Ferias aprovadas com sucesso.');
    }

    public function reprovar(Ferias $feria): RedirectResponse
    {
        $funcionario = $this->funcionarioLogado();
        abort_unless($funcionario->isGestor(), 403);

        $feria->update(['status' => 'reprovado']);

        return back()->with('success', 'Ferias reprovadas.');
    }

    public function destroy(Ferias $feria): RedirectResponse
    {
        $funcionario = $this->funcionarioLogado();

        if ($feria->funcionario_id !== $funcionario->id && ! $funcionario->isGestor()) {
            abort(403);
        }

        if ($feria->status !== 'pendente') {
            return back()->with('error', 'Apenas solicitacoes pendentes podem ser removidas.');
        }

        $feria->delete();

        return redirect()->route('ferias.index')
            ->with('success', 'Solicitacao removida.');
    }
}