<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AjustePonto extends Model
{
    protected $table = 'ajustes_ponto';

    protected $fillable = [
        'funcionario_id',
        'registro_ponto_id',
        'data',
        'tipo',
        'horario_solicitado',
        'motivo',
        'status',
        'aprovado_por',
    ];

    protected $casts = [
        'data' => 'date',
        'horario_solicitado' => 'datetime',
    ];

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function aprovador(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class, 'aprovado_por');
    }

    public function registroPonto(): BelongsTo
    {
        return $this->belongsTo(RegistroPonto::class);
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