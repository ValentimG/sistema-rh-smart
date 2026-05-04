<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ferias;
use App\Models\Atestado;
use App\Models\Funcionario;
use App\Models\RegistroPonto;
use Carbon\Carbon;

class DadosDemoSeeder extends Seeder
{
    public function run(): void
    {
        $funcionarios = Funcionario::where('tipo', 'funcionario')->get();

        foreach ($funcionarios as $index => $f) {
            // Pedidos de ferias para cada funcionario
            Ferias::create([
                'funcionario_id' => $f->id,
                'data_inicio' => now()->addDays(10 + $index * 5),
                'data_fim' => now()->addDays(20 + $index * 5),
                'dias' => 10,
                'observacao' => 'Ferias programadas',
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

        echo "Dados de demonstracao criados: ferias, atestados e registros.\n";
    }
}