<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistroPonto extends Model
{
    /**
     * Força o nome correto da tabela (evita pluralização incorreta: registro_pontos).
     */
    protected $table = 'registros_ponto';

    protected $fillable = [
        'funcionario_id',
        'data',
        'entrada',
        'saida_almoco',
        'volta_almoco',
        'saida',
    ];

    protected $casts = [
        'data'          => 'date',
        'entrada'       => 'datetime',
        'saida_almoco'  => 'datetime',
        'volta_almoco'  => 'datetime',
        'saida'         => 'datetime',
    ];

    // ─── Relacionamentos ────────────────────────────────────────────────────────

    /**
     * Funcionário dono deste registro.
     */
    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }

    // ─── Helpers ────────────────────────────────────────────────────────────────

    /**
     * Calcula as horas trabalhadas no dia.
     *
     * Fórmula: (saida - entrada) - (volta_almoco - saida_almoco)
     * Retorna 0.0 se qualquer campo necessário estiver ausente.
     *
     * @return float Horas trabalhadas (ex: 8.5)
     */
    public function horasTrabalhadas(): float
    {
        if (! $this->entrada || ! $this->saida) {
            return 0.0;
        }

        // diffInSeconds evita truncamento de minutos incompletos
        $totalSegundos = $this->entrada->diffInSeconds($this->saida);

        if ($this->saida_almoco && $this->volta_almoco) {
            $totalSegundos -= $this->saida_almoco->diffInSeconds($this->volta_almoco);
        }

        return round($totalSegundos / 3600, 4);
    }

    /**
     * Retorna as horas trabalhadas no formato HH:MM (ex: "08:30").
     */
    public function horasTrabalhadasFormatado(): string
    {
        $horas = $this->horasTrabalhadas();
        $h = (int) $horas;
        $m = (int) round(($horas - $h) * 60);

        return sprintf('%02d:%02d', $h, $m);
    }
}
