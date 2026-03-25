<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidatoBatismo extends Model
{
    protected $table = 'candidatos_batismo';

    protected $fillable = [
        'turma_id', 'nome', 'telefone', 'email', 'data_nascimento',
        'data_matricula', 'status', 'total_presencas', 'total_faltas',
        'percentual_presenca', 'data_batismo_realizada', 'is_novo',
        'bairro', 'provincia', 'observacoes',
    ];

    protected $casts = [
        'data_nascimento'       => 'date',
        'data_matricula'        => 'date',
        'data_batismo_realizada'=> 'date',
        'is_novo'               => 'boolean',
    ];

    public function turma()
    {
        return $this->belongsTo(TurmaDoutrinaria::class, 'turma_id');
    }

    public function presencas()
    {
        return $this->hasMany(PresencaDoutrinaria::class, 'candidato_id');
    }

    public function getEmRiscoAttribute(): bool
    {
        $totalAulas = $this->turma->aula_atual ?? 0;
        if ($totalAulas === 0) return false;
        return $this->percentual_presenca < 75;
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'ativo'    => 'Activo',
            'inativo'  => 'Inactivo',
            'batizado' => 'Batizado',
            default    => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'ativo'    => 'badge-success',
            'inativo'  => 'badge-neutral',
            'batizado' => 'badge-primary',
            default    => 'badge-neutral',
        };
    }

    public function recalcularPresenca(): void
    {
        $total   = $this->presencas()->count();
        $pres    = $this->presencas()->where('presente', true)->count();
        $faltas  = $total - $pres;
        $pct     = $total > 0 ? round(($pres / $total) * 100, 2) : 0;

        $this->update([
            'total_presencas'    => $pres,
            'total_faltas'       => $faltas,
            'percentual_presenca'=> $pct,
        ]);
    }
}
