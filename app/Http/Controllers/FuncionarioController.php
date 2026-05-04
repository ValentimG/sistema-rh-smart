<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FuncionarioController extends Controller
{
    public function index(): View
    {
        $funcionarios = Funcionario::orderBy('nome')->paginate(10);
        $totalFolha   = Funcionario::sum('salario_base');
        $mediaSalario = Funcionario::whereNotNull('salario_base')->avg('salario_base') ?? 0;

        return view('funcionarios.index', compact('funcionarios', 'totalFolha', 'mediaSalario'));
    }

    public function create(): View
    {
        return view('funcionarios.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome'                        => ['required', 'string', 'max:255'],
            'email'                       => ['required', 'email', 'max:255', 'unique:funcionarios,email'],
            'cpf'                         => ['required', 'string', 'size:14', 'unique:funcionarios,cpf'],
            'endereco'                    => ['required', 'string', 'max:255'],
            'cargo'                       => ['required', 'string', 'max:255'],
            'data_admissao'               => ['required', 'date', 'before_or_equal:today'],
            'tipo'                        => ['required', 'in:funcionario,gestor'],
            'salario_base'                => ['nullable', 'numeric', 'min:0'],
            'carga_horaria_mensal'        => ['nullable', 'integer', 'min:1'],
            'data_nascimento'             => ['nullable', 'date', 'before_or_equal:' . now()->subYears(14)->format('Y-m-d')],
            'sexo'                        => ['nullable', 'in:masculino,feminino,outro,prefiro_nao_informar'],
            'estado_civil'                => ['nullable', 'in:solteiro,casado,divorciado,viuvo,uniao_estavel'],
            'telefone'                    => ['nullable', 'string', 'min:14', 'max:15'],
            'tipo_contrato'               => ['nullable', 'in:clt,pj,estagio,temporario,terceirizado'],
            'beneficios'                  => ['nullable', 'array'],
            'bonificacoes'                => ['nullable', 'array'],
            'exame_admissional_data'      => ['nullable', 'date', 'before_or_equal:today'],
            'exame_admissional_resultado' => ['nullable', 'string', 'max:255'],
            'exame_demissional_data'      => ['nullable', 'date', 'before_or_equal:today'],
            'exame_demissional_resultado' => ['nullable', 'string', 'max:255'],
        ], [
            'data_nascimento.before_or_equal' => 'Voce deve ter pelo menos 14 anos.',
            'telefone.min' => 'Digite o telefone no formato (XX) XXXXX-XXXX.',
        ]);

        Funcionario::create($validated);

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionario cadastrado com sucesso.');
    }

    public function show(Funcionario $funcionario): View
    {
        $mesesTrabalhados = $funcionario->data_admissao->diffInMonths(now());
        $funcionario->load(['atestados' => fn ($q) => $q->orderByDesc('data_inicio'), 'historicoCargos', 'historicoAfastamentos']);
        return view('funcionarios.show', compact('funcionario', 'mesesTrabalhados'));
    }

    public function edit(Funcionario $funcionario): View
    {
        return view('funcionarios.edit', compact('funcionario'));
    }

    public function update(Request $request, Funcionario $funcionario): RedirectResponse
    {
        $validated = $request->validate([
            'nome'                        => ['required', 'string', 'max:255'],
            'email'                       => ['required', 'email', 'max:255', "unique:funcionarios,email,{$funcionario->id}"],
            'cpf'                         => ['required', 'string', 'size:14', "unique:funcionarios,cpf,{$funcionario->id}"],
            'endereco'                    => ['required', 'string', 'max:255'],
            'cargo'                       => ['required', 'string', 'max:255'],
            'data_admissao'               => ['required', 'date', 'before_or_equal:today'],
            'tipo'                        => ['required', 'in:funcionario,gestor'],
            'salario_base'                => ['nullable', 'numeric', 'min:0'],
            'carga_horaria_mensal'        => ['nullable', 'integer', 'min:1'],
            'data_nascimento'             => ['nullable', 'date', 'before_or_equal:' . now()->subYears(14)->format('Y-m-d')],
            'sexo'                        => ['nullable', 'in:masculino,feminino,outro,prefiro_nao_informar'],
            'estado_civil'                => ['nullable', 'in:solteiro,casado,divorciado,viuvo,uniao_estavel'],
            'telefone'                    => ['nullable', 'string', 'min:14', 'max:15'],
            'tipo_contrato'               => ['nullable', 'in:clt,pj,estagio,temporario,terceirizado'],
            'beneficios'                  => ['nullable', 'array'],
            'bonificacoes'                => ['nullable', 'array'],
            'exame_admissional_data'      => ['nullable', 'date', 'before_or_equal:today'],
            'exame_admissional_resultado' => ['nullable', 'string', 'max:255'],
            'exame_demissional_data'      => ['nullable', 'date', 'before_or_equal:today'],
            'exame_demissional_resultado' => ['nullable', 'string', 'max:255'],
        ], [
            'data_nascimento.before_or_equal' => 'Voce deve ter pelo menos 14 anos.',
            'telefone.min' => 'Digite o telefone no formato (XX) XXXXX-XXXX.',
        ]);

        $funcionario->update($validated);

        return redirect()->route('funcionarios.show', $funcionario)
            ->with('success', 'Funcionario atualizado com sucesso.');
    }

    public function destroy(Funcionario $funcionario): RedirectResponse
    {
        $funcionario->delete();
        return redirect()->route('funcionarios.index')->with('success', 'Funcionario removido.');
    }

    public function completarPerfil(): View
    {
        $funcionario = Funcionario::where('user_id', auth()->id())->first();
        abort_if(!$funcionario || $funcionario->isGestor(), 403);
        return view('funcionarios.completar', compact('funcionario'));
    }

    public function salvarPerfil(Request $request): RedirectResponse
    {
        $funcionario = Funcionario::where('user_id', auth()->id())->first();
        abort_if(!$funcionario, 403);

        $validated = $request->validate([
            'cpf' => ['required', 'string', 'min:14', 'max:14', "unique:funcionarios,cpf,{$funcionario->id}"],
            'endereco' => ['required', 'string', 'max:255'],
            'data_nascimento' => ['nullable', 'date', 'before_or_equal:' . now()->subYears(14)->format('Y-m-d')],
            'sexo' => ['nullable', 'in:masculino,feminino,outro,prefiro_nao_informar'],
            'estado_civil' => ['nullable', 'in:solteiro,casado,divorciado,viuvo,uniao_estavel'],
            'telefone' => ['nullable', 'string', 'min:14', 'max:15'],
            'cargo' => ['required', 'string', 'max:255'],
        ], [
            'data_nascimento.before_or_equal' => 'Voce deve ter pelo menos 14 anos.',
            'telefone.min' => 'Digite o telefone no formato (XX) XXXXX-XXXX.',
        ]);

        $funcionario->update($validated);

        return redirect()->route('ponto.index')->with('success', 'Perfil atualizado com sucesso!');
    }
}