<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricoAfastamento extends Model
{
    protected $table = 'historico_afastamentos';

    protected $fillable = [
        'funcionario_id',
        'tipo',
        'data_inicio',
        'data_fim',
        'dias',
        'observacao',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim'    => 'date',
        'dias'        => 'integer',
    ];

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }

    // Rótulos legíveis para o tipo
    public function tipoLabel(): string
    {
        return match ($this->tipo) {
            'ferias'               => 'Férias',
            'licenca_saude'        => 'Licença Saúde',
            'licenca_maternidade'  => 'Lic. Maternidade',
            'licenca_paternidade'  => 'Lic. Paternidade',
            'suspensao'            => 'Suspensão',
            default                => 'Outros',
        };
    }
}
