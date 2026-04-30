<?php

namespace App\Http\Controllers;

use App\Models\Atestado;
use App\Models\Funcionario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AtestadoController extends Controller
{
    private function funcionarioLogado(): Funcionario
    {
        $funcionario = Funcionario::where('user_id', auth()->id())->first();
        abort_unless($funcionario, 403, 'Usuário sem vínculo com funcionário.');
        return $funcionario;
    }

    public function index(Request $request): View
    {
        $atual = $this->funcionarioLogado();

        $query = Atestado::with('funcionario')->orderByDesc('data_inicio');

        if (! $atual->isGestor()) {
            $query->where('funcionario_id', $atual->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $atestados     = $query->paginate(15);
        $funcionarios  = $atual->isGestor() ? Funcionario::orderBy('nome')->get() : collect();

        return view('atestados.index', compact('atestados', 'atual', 'funcionarios'));
    }

    public function create(Request $request): View
    {
        $atual         = $this->funcionarioLogado();
        $funcionarios  = $atual->isGestor() ? Funcionario::orderBy('nome')->get() : collect([$atual]);
        $preSelected   = $request->get('funcionario_id', $atual->id);

        return view('atestados.create', compact('atual', 'funcionarios', 'preSelected'));
    }

    public function store(Request $request): RedirectResponse
    {
        $atual = $this->funcionarioLogado();

        $validated = $request->validate([
            'funcionario_id' => ['required', 'exists:funcionarios,id'],
            'tipo'           => ['required', 'in:medico,odontologico,acompanhamento,outros'],
            'data_inicio'    => ['required', 'date', 'before_or_equal:today'],
            'data_fim'       => ['required', 'date', 'after_or_equal:data_inicio'],
            'cobre_horas'    => ['nullable', 'boolean'],
            'observacao'     => ['nullable', 'string', 'max:1000'],
            'arquivo'        => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            'data_inicio.before_or_equal' => 'A data de início não pode ser futura.',
            'data_fim.after_or_equal' => 'A data final deve ser igual ou posterior à data de início.',
        ]);

        if (! $atual->isGestor()) {
            $validated['funcionario_id'] = $atual->id;
        }

        $validated['dias_afastamento'] = \Carbon\Carbon::parse($validated['data_inicio'])
            ->diffInDays(\Carbon\Carbon::parse($validated['data_fim'])) + 1;

        $validated['cobre_horas'] = $request->boolean('cobre_horas');
        $validated['status']      = 'pendente';

        if ($request->hasFile('arquivo')) {
            $validated['arquivo_path'] = $request->file('arquivo')->store('atestados', 'public');
        }

        Atestado::create($validated);

        return redirect()->route('atestados.index')
            ->with('success', 'Atestado enviado com sucesso. Aguardando análise.');
    }

    public function show(Atestado $atestado): View
    {
        $atual = $this->funcionarioLogado();

        if (! $atual->isGestor() && $atestado->funcionario_id !== $atual->id) {
            abort(403, 'Acesso negado.');
        }

        return view('atestados.show', compact('atestado', 'atual'));
    }

    public function edit(Atestado $atestado): View
    {
        abort(404);
    }

    public function update(Request $request, Atestado $atestado): RedirectResponse
    {
        abort(404);
    }

    public function destroy(Atestado $atestado): RedirectResponse
    {
        $atual = $this->funcionarioLogado();

        if (! $atual->isGestor() && $atestado->funcionario_id !== $atual->id) {
            abort(403, 'Acesso negado.');
        }

        if ($atestado->status !== 'pendente') {
            return back()->with('error', 'Apenas atestados pendentes podem ser removidos.');
        }

        if ($atestado->arquivo_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($atestado->arquivo_path);
        }

        $atestado->delete();

        return redirect()->route('atestados.index')
            ->with('success', 'Atestado removido.');
    }

    public function aprovar(Atestado $atestado): RedirectResponse
    {
        $this->autorizarGestor();

        $atestado->update(['status' => 'aprovado']);

        return back()->with('success', "Atestado de {$atestado->funcionario->nome} aprovado.");
    }

    public function reprovar(Atestado $atestado): RedirectResponse
    {
        $this->autorizarGestor();

        $atestado->update(['status' => 'reprovado']);

        return back()->with('success', "Atestado de {$atestado->funcionario->nome} reprovado.");
    }

    private function autorizarGestor(): void
    {
        $atual = $this->funcionarioLogado();
        abort_unless($atual->isGestor(), 403, 'Apenas gestores podem alterar o status.');
    }
}