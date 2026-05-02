<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ajustes_ponto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionarios')->cascadeOnDelete();
            $table->foreignId('registro_ponto_id')->nullable()->constrained('registros_ponto')->nullOnDelete();
            $table->date('data');
            $table->enum('tipo', ['entrada', 'saida_almoco', 'volta_almoco', 'saida']);
            $table->time('horario_solicitado');
            $table->text('motivo');
            $table->enum('status', ['pendente', 'aprovado', 'reprovado'])->default('pendente');
            $table->foreignId('aprovado_por')->nullable()->constrained('funcionarios')->nullOnDelete();
            $table->timestamps();
        });

        Schema::table('funcionarios', function (Blueprint $table) {
            $table->time('horario_entrada_padrao')->nullable()->after('carga_horaria_mensal');
            $table->integer('tolerancia_atraso_minutos')->default(10)->after('horario_entrada_padrao');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ajustes_ponto');
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropColumn(['horario_entrada_padrao', 'tolerancia_atraso_minutos']);
        });
    }
};