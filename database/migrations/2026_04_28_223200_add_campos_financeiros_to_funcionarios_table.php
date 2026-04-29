<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->decimal('salario_base', 10, 2)->nullable()->after('tipo');
            $table->unsignedInteger('carga_horaria_mensal')->default(220)->after('salario_base');
            $table->decimal('banco_horas', 10, 2)->default(0)->after('carga_horaria_mensal');
        });
    }

    public function down(): void
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropColumn(['salario_base', 'carga_horaria_mensal', 'banco_horas']);
        });
    }
};
