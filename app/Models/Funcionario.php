<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Funcionario extends Model
{
    protected $fillable = [
        'user_id',
        'nome',
        'email',
        'cpf',
        'endereco',
        'cargo',
        'data_admissao',
        'tipo',
        'salario_base',
        'carga_horaria_mensal',
        'banco_horas',
        'data_nascimento',
        'sexo',
        'estado_civil',
        'telefone',
        'foto',
        'tipo_contrato',
        'beneficios',
        'bonificacoes',
        'exame_admissional_data',
        'exame_admissional_resultado',
        'exame_demissional_data',
        'exame_demissional_resultado',
    ];

    protected $casts = [
        'data_admissao' => 'date',
        'data_nascimento' => 'date',
        'exame_admissional_data' => 'date',
        'exame_demissional_data' => 'date',
        'beneficios' => 'array',
        'bonificacoes' => 'array',
        'salario_base' => 'decimal:2',
        'banco_horas' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registrosPonto(): HasMany
    {
        return $this->hasMany(RegistroPonto::class);
    }

    public function atestados(): HasMany
    {
        return $this->hasMany(Atestado::class);
    }

    public function historicoCargos(): HasMany
    {
        return $this->hasMany(HistoricoCargo::class);
    }

    public function historicoAfastamentos(): HasMany
    {
        return $this->hasMany(HistoricoAfastamento::class);
    }

    public function isGestor(): bool
    {
        return $this->tipo === 'gestor';
    }

    public function valorHora(): float
    {
        if (! $this->salario_base || ! $this->carga_horaria_mensal) {
            return 0;
        }
        return round($this->salario_base / $this->carga_horaria_mensal, 2);
    }

    public function estimativaDecimoTerceiro(int $mesesTrabalhados): float
    {
        if (! $this->salario_base) {
            return 0;
        }
        return round(($this->salario_base / 12) * min($mesesTrabalhados, 12), 2);
    }

    public function diasTotaisAfastamento(): int
    {
        return $this->historicoAfastamentos()->sum('dias');
    }

    public function atestadosPendentes(): HasMany
    {
        return $this->atestados()->where('status', 'pendente');
    }

    public function getCpfFormatadoAttribute(): string
    {
        $cpf = $this->cpf;
        if (strlen($cpf) !== 11) {
            return $cpf;
        }
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }

    public function tipoContratoLabel(): string
    {
        return match ($this->tipo_contrato) {
            'clt' => 'CLT',
            'pj' => 'PJ',
            'estagio' => 'Estagio',
            'temporario' => 'Temporario',
            'terceirizado' => 'Terceirizado',
            default => $this->tipo_contrato ?? '—',
        };
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && file_exists(public_path('storage/' . $this->foto))) {
            return asset('storage/' . $this->foto);
        }
        return '';
    }
}