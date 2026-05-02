<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\RegistroPonto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class RegistroPontoController extends Controller
{
    private function funcionarioLogado(): Funcionario
    {
        $funcionario = Funcionario::where('user_id', auth()->id())->first();
        abort_unless($funcionario, 403, 'Usuário sem vínculo com funcionário.');
        return $funcionario;
    }

    private function registroHoje(Funcionario $funcionario): ?RegistroPonto
    {
        return RegistroPonto::where('funcionario_id', $funcionario->id)
            ->whereDate('data', today())
            ->first();
    }

    private function jsonResponse(bool $sucesso, string $mensagem, array $extra = []): JsonResponse
    {
        return response()->json(array_merge([
            'sucesso'  => $sucesso,
            'mensagem' => $mensagem,
        ], $extra));
    }

    public function index(): View
    {
        $funcionario = $this->funcionarioLogado();

        $hoje = $this->registroHoje($funcionario)
            ?? new RegistroPonto(['data' => today()->toDateString()]);

        $historico = RegistroPonto::where('funcionario_id', $funcionario->id)
            ->whereDate('data', '<=', today())
            ->orderByDesc('data')
            ->limit(7)
            ->get();

        $dias = collect(range(6, 0))->map(fn ($i) => now()->subDays($i)->toDateString());

        $chartDias   = $dias->map(fn ($d) => \Carbon\Carbon::parse($d)->isoFormat('ddd D/M'))->toArray();
        $chartHoras  = $dias->map(function ($d) use ($funcionario) {
            $reg = RegistroPonto::where('funcionario_id', $funcionario->id)
                ->whereDate('data', $d)
                ->first();
            return $reg ? round($reg->horasTrabalhadas(), 2) : 0;
        })->toArray();

        $bancoHoras = (float) $funcionario->banco_horas;

        return view('registros.index', compact(
            'funcionario', 'hoje', 'historico',
            'chartDias', 'chartHoras', 'bancoHoras'
        ));
    }

    public function registrarEntrada(Request $request): JsonResponse
    {
        $funcionario = $this->funcionarioLogado();
        $registro = $this->registroHoje($funcionario);

        if ($registro?->entrada) {
            return $this->jsonResponse(false, 'Entrada já registrada hoje.');
        }

        RegistroPonto::updateOrCreate(
            ['funcionario_id' => $funcionario->id, 'data' => today()->toDateString()],
            ['entrada' => now()]
        );

        return $this->jsonResponse(true, 'Entrada registrada com sucesso.', [
            'horario' => now()->format('H:i'),
        ]);
    }

    public function registrarSaidaAlmoco(Request $request): JsonResponse
    {
        $funcionario = $this->funcionarioLogado();
        $registro    = $this->registroHoje($funcionario);

        if (! $registro?->entrada) {
            return $this->jsonResponse(false, 'Registre a entrada antes de sair para o almoço.');
        }
        if ($registro->saida_almoco) {
            return $this->jsonResponse(false, 'Saída para almoço já registrada.');
        }

        $registro->saida_almoco = now();
        $registro->save();

        return $this->jsonResponse(true, 'Saída para almoço registrada.', [
            'horario' => now()->format('H:i'),
        ]);
    }

    public function registrarVoltaAlmoco(Request $request): JsonResponse
    {
        $funcionario = $this->funcionarioLogado();
        $registro    = $this->registroHoje($funcionario);

        if (! $registro?->saida_almoco) {
            return $this->jsonResponse(false, 'Registre a saída para almoço antes.');
        }
        if ($registro->volta_almoco) {
            return $this->jsonResponse(false, 'Volta do almoço já registrada.');
        }

        $registro->volta_almoco = now();
        $registro->save();

        return $this->jsonResponse(true, 'Volta do almoço registrada.', [
            'horario' => now()->format('H:i'),
        ]);
    }

    public function registrarSaida(Request $request): JsonResponse
    {
        $funcionario = $this->funcionarioLogado();
        $registro    = $this->registroHoje($funcionario);

        if (! $registro?->entrada) {
            return $this->jsonResponse(false, 'Registre a entrada antes de sair.');
        }
        if ($registro->saida_almoco && ! $registro->volta_almoco) {
            return $this->jsonResponse(false, 'Registre a volta do almoço antes de encerrar.');
        }
        if ($registro->saida) {
            return $this->jsonResponse(false, 'Saída já registrada para hoje.');
        }

        $registro->saida = now();
        $registro->save();

        return $this->jsonResponse(true, 'Jornada encerrada com sucesso.', [
            'horario'           => now()->format('H:i'),
            'horas_trabalhadas' => $registro->horasTrabalhadasFormatado(),
        ]);
    }

    public function dashboardGestor(): View
    {
        $funcionario = $this->funcionarioLogado();
        abort_unless($funcionario->isGestor(), 403, 'Acesso exclusivo para gestores.');

        $totalFuncionarios = Funcionario::count();

        $registrosHoje = RegistroPonto::with('funcionario')
            ->whereDate('data', today())
            ->orderBy('funcionario_id')
            ->get();

        $idsComRegistro = $registrosHoje->pluck('funcionario_id');
        $semPontoHoje   = Funcionario::whereNotIn('id', $idsComRegistro)->get();

        $todosFuncionarios = Funcionario::orderBy('nome')->get();
        $chartBancoLabels  = $todosFuncionarios->pluck('nome')->map(fn ($n) => explode(' ', $n)[0])->toArray();
        $chartBancoData    = $todosFuncionarios->pluck('banco_horas')->map(fn ($v) => (float) $v)->toArray();

        $totalHorasHoje = $registrosHoje->sum(fn ($r) => $r->horasTrabalhadas());

        $registros7dias = RegistroPonto::whereNotNull('saida')
            ->whereDate('data', '>=', now()->subDays(6)->toDateString())
            ->get();
        $mediaHorasSemana = $registros7dias->count() > 0
            ? round($registros7dias->sum(fn ($r) => $r->horasTrabalhadas()) / $registros7dias->count(), 2)
            : 0;

        $maiorBanco = $todosFuncionarios->sortByDesc('banco_horas')->first();
        $maisFaltas = $todosFuncionarios->sortByDesc(fn ($f) => $f->diasTotaisAfastamento())->first();

        $chartPresentes = $registrosHoje->count();
        $chartAusentes  = $semPontoHoje->count();

        return view('registros.gestor', compact(
            'funcionario',
            'totalFuncionarios',
            'registrosHoje',
            'semPontoHoje',
            'chartBancoLabels',
            'chartBancoData',
            'totalHorasHoje',
            'mediaHorasSemana',
            'maiorBanco',
            'maisFaltas',
            'chartPresentes',
            'chartAusentes',
        ));
    }

    public function exportarCsv(): StreamedResponse
    {
        $funcionario = $this->funcionarioLogado();
        abort_unless($funcionario->isGestor(), 403, 'Acesso exclusivo para gestores.');

        $mes      = now()->format('Y-m');
        $arquivo  = 'registros_ponto_' . $mes . '.csv';

        $registros = RegistroPonto::with('funcionario')
            ->whereYear('data', now()->year)
            ->whereMonth('data', now()->month)
            ->orderBy('data')
            ->orderBy('funcionario_id')
            ->get();

        $response = new StreamedResponse(function () use ($registros) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Data', 'Funcionario', 'Cargo', 'Entrada', 'Saida Almoco', 'Volta Almoco', 'Saida', 'Horas Trabalhadas',
            ], ';');

            foreach ($registros as $r) {
                $h   = (int) $r->horasTrabalhadas();
                $min = (int) round(($r->horasTrabalhadas() - $h) * 60);

                fputcsv($handle, [
                    $r->data->format('d/m/Y'),
                    $r->funcionario->nome,
                    $r->funcionario->cargo,
                    $r->entrada      ? $r->entrada->format('H:i')      : '',
                    $r->saida_almoco ? $r->saida_almoco->format('H:i') : '',
                    $r->volta_almoco ? $r->volta_almoco->format('H:i') : '',
                    $r->saida        ? $r->saida->format('H:i')        : '',
                    $r->horasTrabalhadas() > 0 ? sprintf('%02d:%02d', $h, $min) : '',
                ], ';');
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $arquivo . '"');

        return $response;
    }

    public function extratoBancoHoras(): View
    {
        $funcionario = $this->funcionarioLogado();

        $registros = RegistroPonto::where('funcionario_id', $funcionario->id)
            ->whereNotNull('saida')
            ->whereDate('data', '>=', now()->subDays(90))
            ->orderByDesc('data')
            ->get();

        $labels = $registros->pluck('data')->map(fn($d) => $d->format('d/m'))->reverse()->values()->toArray();
        $horas = $registros->map(fn($r) => round($r->horasTrabalhadas(), 2))->reverse()->values()->toArray();

        $saldos = [];
        $saldoAcumulado = (float) $funcionario->banco_horas;

        foreach ($horas as $h) {
            $saldoAcumulado -= ($h - 8);
            $saldos[] = round($saldoAcumulado, 2);
        }

        $saldoAtual = (float) $funcionario->banco_horas;

        return view('registros.extrato', compact(
            'funcionario',
            'registros',
            'saldoAtual',
            'labels',
            'horas',
            'saldos'
        ));
    }

    public function extratoFuncionario(Funcionario $funcionario): View
    {
        $gestor = $this->funcionarioLogado();
        abort_unless($gestor->isGestor(), 403);

        $registros = RegistroPonto::where('funcionario_id', $funcionario->id)
            ->whereNotNull('saida')
            ->whereDate('data', '>=', now()->subDays(90))
            ->orderByDesc('data')
            ->get();

        $labels = $registros->pluck('data')->map(fn($d) => $d->format('d/m'))->reverse()->values()->toArray();
        $horas = $registros->map(fn($r) => round($r->horasTrabalhadas(), 2))->reverse()->values()->toArray();

        $saldos = [];
        $saldoAcumulado = (float) $funcionario->banco_horas;

        foreach ($horas as $h) {
            $saldoAcumulado -= ($h - 8);
            $saldos[] = round($saldoAcumulado, 2);
        }

        $saldoAtual = (float) $funcionario->banco_horas;

        return view('registros.extrato', compact(
            'funcionario',
            'registros',
            'saldoAtual',
            'labels',
            'horas',
            'saldos'
        ));
    }
}