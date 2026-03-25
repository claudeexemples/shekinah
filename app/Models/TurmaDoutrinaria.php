<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TurmaDoutrinaria extends Model
{
    protected $table = 'turmas_doutrinaria';

    protected $fillable = [
        'nome', 'data_inicio', 'data_fim_prevista', 'total_aulas_previstas',
        'aula_atual', 'professor', 'sala', 'ativa', 'data_batismo_prevista', 'observacoes',
    ];

    protected $casts = [
        'ativa'               => 'boolean',
        'data_inicio'         => 'date',
        'data_fim_prevista'   => 'date',
        'data_batismo_prevista'=> 'date',
    ];

    public function candidatos()
    {
        return $this->hasMany(CandidatoBatismo::class, 'turma_id');
    }

    public function presencas()
    {
        return $this->hasMany(PresencaDoutrinaria::class, 'turma_id');
    }

    public function getFrequenciaMediaAttribute(): float
    {
        $candidatos = $this->candidatos()->where('status', 'ativo')->get();
        if ($candidatos->isEmpty()) return 0;
        return round($candidatos->avg('percentual_presenca'), 1);
    }

    public function getCandidatosEmRiscoAttribute()
    {
        return $this->candidatos()->where('status', 'ativo')
            ->where('percentual_presenca', '<', 75)->get();
    }

    public function getProgressoAttribute(): int
    {
        if ($this->total_aulas_previstas === 0) return 0;
        return (int) round(($this->aula_atual / $this->total_aulas_previstas) * 100);
    }
}
