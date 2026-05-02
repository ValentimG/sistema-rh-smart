<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ferias extends Model
{
    protected $table = 'ferias';

    protected $fillable = [
        'funcionario_id',
        'data_inicio',
        'data_fim',
        'dias',
        'observacao',
        'status',
        'aprovado_por',
        'aprovado_em',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'aprovado_em' => 'datetime',
    ];

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function aprovador(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class, 'aprovado_por');
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'aprovado' => 'Aprovado',
            'reprovado' => 'Reprovado',
            default => 'Pendente',
        };
    }
}