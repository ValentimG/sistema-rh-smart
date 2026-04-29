<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Atestado extends Model
{
    protected $fillable = [
        'funcionario_id',
        'tipo',
        'data_inicio',
        'data_fim',
        'dias_afastamento',
        'cobre_horas',
        'observacao',
        'arquivo_path',
        'status',
    ];

    protected $casts = [
        'data_inicio'      => 'date',
        'data_fim'         => 'date',
        'cobre_horas'      => 'boolean',
        'dias_afastamento' => 'integer',
    ];

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }

    // Rótulos legíveis para o tipo
    public function tipoLabel(): string
    {
        return match ($this->tipo) {
            'medico'          => 'Médico',
            'odontologico'    => 'Odontológico',
            'acompanhamento'  => 'Acompanhamento',
            default           => 'Outros',
        };
    }

    // Rótulos legíveis para o status
    public function statusLabel(): string
    {
        return match ($this->status) {
            'aprovado'  => 'Aprovado',
            'reprovado' => 'Reprovado',
            default     => 'Pendente',
        };
    }
}
