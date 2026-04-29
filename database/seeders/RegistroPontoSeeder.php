<?php

namespace Database\Seeders;

use App\Models\Funcionario;
use App\Models\RegistroPonto;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RegistroPontoSeeder extends Seeder
{
    public function run(): void
    {
        $funcionarios = Funcionario::all();

        // Horários variados por funcionário (entrada, saida_almoco, volta_almoco, saida)
        $perfis = [
            ['08:00', '12:00', '13:00', '17:00'], // normal
            ['07:30', '12:00', '13:00', '17:30'], // pontual cedo
            ['09:00', '12:30', '13:30', '18:30'], // tarde + hora extra
            ['08:00', '12:00', '13:00', '18:00'], // hora extra
            ['08:30', '12:15', '13:15', '17:15'], // normal
        ];

        foreach ($funcionarios as $idx => $func) {
            $perfil = $perfis[$idx % count($perfis)];

            for ($diasAtras = 6; $diasAtras >= 0; $diasAtras--) {
                $data = Carbon::today()->subDays($diasAtras);

                // Pula domingos
                if ($data->isSunday()) {
                    continue;
                }

                // Funcionário 4 (Eduardo) faltou segunda e quarta
                if ($idx === 4 && in_array($diasAtras, [6, 4])) {
                    continue;
                }

                // Sábado: somente gestor e 1 funcionário trabalham meio período
                if ($data->isSaturday()) {
                    if ($idx > 1) {
                        continue;
                    }
                    // Meio período no sábado
                    RegistroPonto::updateOrCreate(
                        ['funcionario_id' => $func->id, 'data' => $data->toDateString()],
                        [
                            'entrada'       => $data->copy()->setTimeFromTimeString('08:00'),
                            'saida_almoco'  => null,
                            'volta_almoco'  => null,
                            'saida'         => $data->copy()->setTimeFromTimeString('12:00'),
                        ]
                    );
                    continue;
                }

                // Adiciona variação aleatória determinística (sem rand)
                $varE = ($idx + $diasAtras) % 3;           // 0, 1 ou 2 minutos de variação
                $varS = ($idx * 2 + $diasAtras) % 15;      // 0-14 minutos a mais na saída

                $entrada      = Carbon::parse($data->toDateString() . ' ' . $perfil[0])->addMinutes($varE);
                $saidaAlmoco  = Carbon::parse($data->toDateString() . ' ' . $perfil[1]);
                $voltaAlmoco  = Carbon::parse($data->toDateString() . ' ' . $perfil[2]);
                $saida        = Carbon::parse($data->toDateString() . ' ' . $perfil[3])->addMinutes($varS);

                // Hoje: somente registra entrada (jornada em andamento para alguns)
                if ($diasAtras === 0) {
                    RegistroPonto::updateOrCreate(
                        ['funcionario_id' => $func->id, 'data' => $data->toDateString()],
                        [
                            'entrada'      => $entrada,
                            'saida_almoco' => null,
                            'volta_almoco' => null,
                            'saida'        => null,
                        ]
                    );
                    continue;
                }

                RegistroPonto::updateOrCreate(
                    ['funcionario_id' => $func->id, 'data' => $data->toDateString()],
                    [
                        'entrada'      => $entrada,
                        'saida_almoco' => $saidaAlmoco,
                        'volta_almoco' => $voltaAlmoco,
                        'saida'        => $saida,
                    ]
                );
            }
        }

        $this->command->info('Registros de ponto criados para os ultimos 7 dias.');
    }
}
