<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historico_afastamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionarios')->cascadeOnDelete();
            $table->enum('tipo', [
                'ferias',
                'licenca_saude',
                'licenca_maternidade',
                'licenca_paternidade',
                'suspensao',
                'outros',
            ]);
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->unsignedInteger('dias');
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historico_afastamentos');
    }
};
