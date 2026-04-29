<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registros_ponto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionarios')->cascadeOnDelete();
            $table->date('data');
            $table->dateTime('entrada')->nullable();
            $table->dateTime('saida_almoco')->nullable();
            $table->dateTime('volta_almoco')->nullable();
            $table->dateTime('saida')->nullable();
            $table->timestamps();

            $table->unique(['funcionario_id', 'data']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_ponto');
    }
};
