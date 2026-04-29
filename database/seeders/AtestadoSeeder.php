<?php

namespace Database\Seeders;

use App\Models\Atestado;
use App\Models\Funcionario;
use Illuminate\Database\Seeder;

class AtestadoSeeder extends Seeder
{
    public function run(): void
    {
        $ana      = Funcionario::where('email', 'funcionario1@teste.com')->first();
        $bruno    = Funcionario::where('email', 'funcionario2@teste.com')->first();
        $eduardo  = Funcionario::where('email', 'funcionario4@teste.com')->first();

        if ($ana) {
            Atestado::create([
                'funcionario_id'   => $ana->id,
                'tipo'             => 'medico',
                'data_inicio'      => '2026-04-10',
                'data_fim'         => '2026-04-11',
                'dias_afastamento' => 2,
                'cobre_horas'      => true,
                'observacao'       => 'Gripe com recomendação de repouso.',
                'arquivo_path'     => null,
                'status'           => 'aprovado',
            ]);
        }

        if ($bruno) {
            Atestado::create([
                'funcionario_id'   => $bruno->id,
                'tipo'             => 'odontologico',
                'data_inicio'      => '2026-04-25',
                'data_fim'         => '2026-04-25',
                'dias_afastamento' => 1,
                'cobre_horas'      => true,
                'observacao'       => 'Extração dentária. Meio período de afastamento.',
                'arquivo_path'     => null,
                'status'           => 'pendente',
            ]);
        }

        if ($eduardo) {
            Atestado::create([
                'funcionario_id'   => $eduardo->id,
                'tipo'             => 'acompanhamento',
                'data_inicio'      => '2026-04-20',
                'data_fim'         => '2026-04-20',
                'dias_afastamento' => 1,
                'cobre_horas'      => false,
                'observacao'       => 'Acompanhamento de familiar. Documento insuficiente para aprovação.',
                'arquivo_path'     => null,
                'status'           => 'reprovado',
            ]);
        }

        $this->command->info('AtestadoSeeder: 3 atestados criados (aprovado, pendente, reprovado).');
    }
}
