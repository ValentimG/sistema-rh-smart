<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            // Dados pessoais complementares
            $table->date('data_nascimento')->nullable()->after('nome');
            $table->enum('sexo', ['masculino', 'feminino', 'outro', 'prefiro_nao_informar'])->nullable()->after('data_nascimento');
            $table->enum('estado_civil', ['solteiro', 'casado', 'divorciado', 'viuvo', 'uniao_estavel'])->nullable()->after('sexo');
            $table->string('telefone', 20)->nullable()->after('estado_civil');

            // Dados contratuais
            $table->enum('tipo_contrato', ['clt', 'pj', 'estagio', 'temporario', 'terceirizado'])->default('clt')->after('tipo');
            $table->text('beneficios')->nullable()->after('tipo_contrato');
            $table->text('bonificacoes')->nullable()->after('beneficios');

            // Saúde e segurança
            $table->date('exame_admissional_data')->nullable()->after('bonificacoes');
            $table->string('exame_admissional_resultado')->nullable()->after('exame_admissional_data');
            $table->date('exame_demissional_data')->nullable()->after('exame_admissional_resultado');
            $table->string('exame_demissional_resultado')->nullable()->after('exame_demissional_data');
        });
    }

    public function down(): void
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropColumn([
                'data_nascimento', 'sexo', 'estado_civil', 'telefone',
                'tipo_contrato', 'beneficios', 'bonificacoes',
                'exame_admissional_data', 'exame_admissional_resultado',
                'exame_demissional_data', 'exame_demissional_resultado',
            ]);
        });
    }
};
