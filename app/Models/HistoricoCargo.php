<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricoCargo extends Model
{
    protected $table = 'historico_cargos';

    protected $fillable = [
        'funcionario_id',
        'cargo',
        'data_inicio',
        'data_fim',
        'motivo',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim'    => 'date',
    ];

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }

    // Indica se este é o cargo atual (sem data_fim)
    public function isAtual(): bool
    {
        return is_null($this->data_fim);
    }
}
