<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atestados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionarios')->cascadeOnDelete();
            $table->enum('tipo', ['medico', 'odontologico', 'acompanhamento', 'outros']);
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->unsignedInteger('dias_afastamento');
            $table->boolean('cobre_horas')->default(true);
            $table->text('observacao')->nullable();
            $table->string('arquivo_path')->nullable();
            $table->enum('status', ['pendente', 'aprovado', 'reprovado'])->default('pendente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atestados');
    }
};
