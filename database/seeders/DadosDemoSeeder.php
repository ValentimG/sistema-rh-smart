<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ferias;
use App\Models\Atestado;
use App\Models\Funcionario;
use App\Models\EventoCalendario;
use Carbon\Carbon;

class DadosDemoSeeder extends Seeder
{
    public function run(): void
    {
        $funcionarios = Funcionario::where('tipo', 'funcionario')->get();

        // Eventos da empresa (visivel para todos)
        $eventosEmpresa = [
            ['data' => '2026-05-01', 'titulo' => 'Feriado - Dia do Trabalho', 'tipo' => 'feriado'],
            ['data' => '2026-06-15', 'titulo' => 'Feriado - Corpus Christi', 'tipo' => 'feriado'],
            ['data' => '2026-09-07', 'titulo' => 'Feriado - Independencia do Brasil', 'tipo' => 'feriado'],
            ['data' => '2026-10-12', 'titulo' => 'Feriado - Nossa Senhora Aparecida', 'tipo' => 'feriado'],
            ['data' => '2026-11-02', 'titulo' => 'Feriado - Finados', 'tipo' => 'feriado'],
            ['data' => '2026-11-15', 'titulo' => 'Feriado - Proclamacao da Republica', 'tipo' => 'feriado'],
            ['data' => '2026-12-25', 'titulo' => 'Feriado - Natal', 'tipo' => 'feriado'],
            ['data' => '2026-05-10', 'titulo' => 'Reuniao Geral - Apresentacao de Resultados', 'tipo' => 'evento_empresa'],
            ['data' => '2026-06-20', 'titulo' => 'Confraternizacao da Empresa', 'tipo' => 'evento_empresa'],
            ['data' => '2026-08-15', 'titulo' => 'Treinamento de Seguranca', 'tipo' => 'evento_empresa'],
            ['data' => '2026-10-28', 'titulo' => 'Workshop de Inovacao', 'tipo' => 'evento_empresa'],
            ['data' => '2026-12-20', 'titulo' => 'Amigo Secreto da Empresa', 'tipo' => 'evento_empresa'],
        ];

        foreach ($eventosEmpresa as $evento) {
            EventoCalendario::create([
                'data' => $evento['data'],
                'titulo' => $evento['titulo'],
                'tipo' => $evento['tipo'],
                'visivel_todos' => true,
            ]);
        }

        // Eventos pessoais + ferias para cada funcionario
        $eventosPessoais = [
            ['Reuniao com cliente', '2026-05-05'],
            ['Entrega de projeto', '2026-05-15'],
            ['Almoco de equipe', '2026-05-20'],
            ['Revisao de codigo', '2026-06-01'],
            ['Planejamento mensal', '2026-06-05'],
        ];

        foreach ($funcionarios as $index => $f) {
            // 2 eventos pessoais por funcionario
            $pessoal1 = $eventosPessoais[$index % count($eventosPessoais)];
            $pessoal2 = $eventosPessoais[($index + 1) % count($eventosPessoais)];

            EventoCalendario::create([
                'funcionario_id' => $f->id,
                'data' => $pessoal1[1],
                'titulo' => $pessoal1[0],
                'tipo' => 'pessoal',
                'visivel_todos' => false,
            ]);

            EventoCalendario::create([
                'funcionario_id' => $f->id,
                'data' => $pessoal2[1],
                'titulo' => $pessoal2[0],
                'tipo' => 'pessoal',
                'visivel_todos' => false,
            ]);

            // 2 pedidos de ferias por funcionario
            Ferias::create([
                'funcionario_id' => $f->id,
                'data_inicio' => now()->addDays(10 + $index * 5),
                'data_fim' => now()->addDays(20 + $index * 5),
                'dias' => 10,
                'observacao' => 'Ferias programadas - periodo 1',
                'status' => $index % 2 == 0 ? 'aprovado' : 'pendente',
            ]);

            Ferias::create([
                'funcionario_id' => $f->id,
                'data_inicio' => now()->subDays(30 + $index * 10),
                'data_fim' => now()->subDays(20 + $index * 10),
                'dias' => 10,
                'observacao' => 'Ferias ja realizadas',
                'status' => 'aprovado',
            ]);
        }

        echo "Calendario com feriados, eventos da empresa e eventos pessoais criados.\n";
    }
}