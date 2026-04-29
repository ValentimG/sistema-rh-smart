<?php

namespace Database\Seeders;

use App\Models\Funcionario;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FuncionarioSeeder extends Seeder
{
    public function run(): void
    {
        $pessoas = [
            [
                'tipo'                 => 'gestor',
                'name'                 => 'Carlos Mendes',
                'email'                => 'gestor@teste.com',
                'cpf'                  => '123.456.789-00',
                'endereco'             => 'Rua das Palmeiras, 100 - São Paulo/SP',
                'cargo'                => 'Gerente de RH',
                'data_admissao'        => '2020-03-01',
                'salario_base'         => 8500.00,
                'carga_horaria_mensal' => 220,
                'banco_horas'          => 4.5,
                'data_nascimento'      => '1982-07-15',
                'sexo'                 => 'masculino',
                'estado_civil'         => 'casado',
                'telefone'             => '(11) 98765-4321',
                'tipo_contrato'        => 'clt',
                'beneficios'           => ['Vale Refeição', 'Vale Transporte', 'Plano de Saúde', 'Plano Odontológico', 'Seguro de Vida'],
            ],
            [
                'tipo'                 => 'funcionario',
                'name'                 => 'Ana Silva',
                'email'                => 'funcionario1@teste.com',
                'cpf'                  => '234.567.890-11',
                'endereco'             => 'Av. Brasil, 200 - São Paulo/SP',
                'cargo'                => 'Desenvolvedora Backend',
                'data_admissao'        => '2021-06-15',
                'salario_base'         => 6200.00,
                'carga_horaria_mensal' => 220,
                'banco_horas'          => 12.0,
                'data_nascimento'      => '1995-03-22',
                'sexo'                 => 'feminino',
                'estado_civil'         => 'solteiro',
                'telefone'             => '(11) 91234-5678',
                'tipo_contrato'        => 'clt',
                'beneficios'           => ['Vale Refeição', 'Vale Alimentação', 'Vale Transporte', 'Plano de Saúde', 'Gympass'],
            ],
            [
                'tipo'                 => 'funcionario',
                'name'                 => 'Bruno Costa',
                'email'                => 'funcionario2@teste.com',
                'cpf'                  => '345.678.901-22',
                'endereco'             => 'Rua das Flores, 300 - Campinas/SP',
                'cargo'                => 'Designer UX',
                'data_admissao'        => '2022-01-10',
                'salario_base'         => 5800.00,
                'carga_horaria_mensal' => 220,
                'banco_horas'          => -2.5,
                'data_nascimento'      => '1997-11-08',
                'sexo'                 => 'masculino',
                'estado_civil'         => 'solteiro',
                'telefone'             => '(19) 99876-5432',
                'tipo_contrato'        => 'clt',
                'beneficios'           => ['Vale Refeição', 'Vale Transporte', 'Plano de Saúde'],
            ],
            [
                'tipo'                 => 'funcionario',
                'name'                 => 'Débora Souza',
                'email'                => 'funcionario3@teste.com',
                'cpf'                  => '456.789.012-33',
                'endereco'             => 'Rua do Comércio, 45 - Santos/SP',
                'cargo'                => 'Analista Financeira',
                'data_admissao'        => '2022-08-22',
                'salario_base'         => 5500.00,
                'carga_horaria_mensal' => 220,
                'banco_horas'          => 8.0,
                'data_nascimento'      => '1993-05-30',
                'sexo'                 => 'feminino',
                'estado_civil'         => 'casado',
                'telefone'             => '(13) 98765-1234',
                'tipo_contrato'        => 'clt',
                'beneficios'           => ['Vale Refeição', 'Vale Alimentação', 'Vale Transporte', 'Plano de Saúde', 'Plano Odontológico'],
            ],
            [
                'tipo'                 => 'funcionario',
                'name'                 => 'Eduardo Lima',
                'email'                => 'funcionario4@teste.com',
                'cpf'                  => '567.890.123-44',
                'endereco'             => 'Alameda Santos, 500 - São Paulo/SP',
                'cargo'                => 'Analista Financeiro',
                'data_admissao'        => '2023-02-01',
                'salario_base'         => 5500.00,
                'carga_horaria_mensal' => 220,
                'banco_horas'          => -5.0,
                'data_nascimento'      => '1998-09-14',
                'sexo'                 => 'masculino',
                'estado_civil'         => 'solteiro',
                'telefone'             => '(11) 97654-3210',
                'tipo_contrato'        => 'pj',
                'beneficios'           => ['Vale Refeição', 'Vale Transporte'],
            ],
            [
                'tipo'                 => 'funcionario',
                'name'                 => 'Fernanda Rocha',
                'email'                => 'funcionario5@teste.com',
                'cpf'                  => '678.901.234-55',
                'endereco'             => 'Rua Consolação, 750 - São Paulo/SP',
                'cargo'                => 'Desenvolvedora Frontend',
                'data_admissao'        => '2023-09-05',
                'salario_base'         => 6000.00,
                'carga_horaria_mensal' => 220,
                'banco_horas'          => 1.5,
                'data_nascimento'      => '1999-01-25',
                'sexo'                 => 'feminino',
                'estado_civil'         => 'solteiro',
                'telefone'             => '(11) 96543-2109',
                'tipo_contrato'        => 'clt',
                'beneficios'           => ['Vale Refeição', 'Vale Alimentação', 'Vale Transporte', 'Plano de Saúde', 'Gympass', 'PLR'],
            ],
        ];

        foreach ($pessoas as $dados) {
            $user = User::create([
                'name'     => $dados['name'],
                'email'    => $dados['email'],
                'password' => Hash::make('12345678'),
            ]);

            Funcionario::create([
                'user_id'              => $user->id,
                'nome'                 => $dados['name'],
                'email'                => $dados['email'],
                'cpf'                  => $dados['cpf'],
                'endereco'             => $dados['endereco'],
                'cargo'                => $dados['cargo'],
                'data_admissao'        => $dados['data_admissao'],
                'tipo'                 => $dados['tipo'],
                'salario_base'         => $dados['salario_base'],
                'carga_horaria_mensal' => $dados['carga_horaria_mensal'],
                'banco_horas'          => $dados['banco_horas'],
                'data_nascimento'      => $dados['data_nascimento'],
                'sexo'                 => $dados['sexo'],
                'estado_civil'         => $dados['estado_civil'],
                'telefone'             => $dados['telefone'],
                'tipo_contrato'        => $dados['tipo_contrato'],
                'beneficios'           => $dados['beneficios'],
            ]);
        }

        $this->command->table(
            ['Tipo', 'Nome', 'Email', 'Cargo', 'Salário', 'Banco Hrs', 'Senha'],
            collect($pessoas)->map(fn ($p) => [
                strtoupper($p['tipo']),
                $p['name'],
                $p['email'],
                $p['cargo'],
                'R$ ' . number_format($p['salario_base'], 2, ',', '.'),
                ($p['banco_horas'] >= 0 ? '+' : '') . $p['banco_horas'] . 'h',
                '12345678',
            ])->toArray()
        );
    }
}
