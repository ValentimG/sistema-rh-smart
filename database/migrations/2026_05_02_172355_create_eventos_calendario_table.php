<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos_calendario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->nullable()->constrained('funcionarios')->nullOnDelete();
            $table->date('data');
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->string('tipo')->default('pessoal'); // pessoal, feriado, evento_empresa
            $table->boolean('visivel_todos')->default(false); // true = todos veem (gestor)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos_calendario');
    }
};