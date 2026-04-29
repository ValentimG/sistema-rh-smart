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
        // Dados pessoais expandidos
        'data_nascimento',
        'sexo',
        'estado_civil',
        'telefone',
        // Dados contratuais
        'tipo_contrato',
        'beneficios',
        'bonificacoes',
        // Saúde
        'exame_admissional_data',
        'exame_admissional_resultado',
        'exame_demissional_data',
        'exame_demissional_resultado',
    ];

    protected $casts = [
        'data_admissao'            => 'date',
        'data_nascimento'          => 'date',
        'exame_admissional_data'   => 'date',
        'exame_demissional_data'   => 'date',
        'salario_base'             => 'decimal:2',
        'carga_horaria_mensal'     => 'integer',
        'banco_horas'              => 'decimal:2',
        'beneficios'               => 'array',
        'bonificacoes'             => 'array',
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
        return $this->hasMany(HistoricoCargo::class)->orderByDesc('data_inicio');
    }

    public function historicoAfastamentos(): HasMany
    {
        return $this->hasMany(HistoricoAfastamento::class)->orderByDesc('data_inicio');
    }

    public function isGestor(): bool
    {
        return $this->tipo === 'gestor';
    }

    public function valorHora(): float
    {
        if (! $this->salario_base || ! $this->carga_horaria_mensal) {
            return 0.0;
        }
        return round($this->salario_base / $this->carga_horaria_mensal, 4);
    }

    public function salarioProporcionalDia(): float
    {
        return round($this->valorHora() * 8, 2);
    }

    public function estimativaDecimoTerceiro(int $mesesTrabalhados): float
    {
        if (! $this->salario_base) {
            return 0.0;
        }
        return round(($this->salario_base / 12) * $mesesTrabalhados, 2);
    }

    // Soma total de dias em todos os afastamentos registrados
    public function diasTotaisAfastamento(): int
    {
        return $this->historicoAfastamentos()->sum('dias');
    }

    // Retorna atestados aguardando análise
    public function atestadosPendentes(): HasMany
    {
        return $this->hasMany(Atestado::class)->where('status', 'pendente');
    }

    // Rótulo legível para tipo de contrato
    public function tipoContratoLabel(): string
    {
        return match ($this->tipo_contrato) {
            'clt'          => 'CLT',
            'pj'           => 'Pessoa Jurídica',
            'estagio'      => 'Estágio',
            'temporario'   => 'Temporário',
            'terceirizado' => 'Terceirizado',
            default        => $this->tipo_contrato,
        };
    }

    // Formata o CPF para exibição (ex: 123.456.789-00)
    public function getCpfFormatadoAttribute(): string
    {
        $cpf = preg_replace('/\D/', '', $this->cpf ?? '');

        if (strlen($cpf) !== 11) {
            return $this->cpf ?? '';
        }

        return substr($cpf, 0, 3) . '.' .
               substr($cpf, 3, 3) . '.' .
               substr($cpf, 6, 3) . '-' .
               substr($cpf, 9, 2);
    }
}
