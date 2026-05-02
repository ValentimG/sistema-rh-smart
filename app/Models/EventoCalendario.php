<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventoCalendario extends Model
{
    protected $table = 'eventos_calendario';

    protected $fillable = [
        'funcionario_id', 'data', 'titulo', 'descricao', 'tipo', 'visivel_todos'
    ];

    protected $casts = [
        'data' => 'date',
        'visivel_todos' => 'boolean',
    ];

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }
}