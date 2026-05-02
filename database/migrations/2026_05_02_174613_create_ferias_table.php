<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ferias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionarios')->cascadeOnDelete();
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->integer('dias')->comment('Total de dias solicitados');
            $table->text('observacao')->nullable();
            $table->enum('status', ['pendente', 'aprovado', 'reprovado'])->default('pendente');
            $table->foreignId('aprovado_por')->nullable()->constrained('funcionarios')->nullOnDelete();
            $table->timestamp('aprovado_em')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ferias');
    }
};