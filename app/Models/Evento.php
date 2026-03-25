<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'data', 'tipo_evento', 'horario_inicio', 'horario_fim',
        'pregador', 'tema_culto', 'observacoes',
    ];

    protected $casts = [
        'data' => 'date',
    ];

    /* Relationships */
    public function presencaCulto()
    {
        return $this->hasOne(PresencaCulto::class);
    }

    public function visitantes()
    {
        return $this->hasMany(Visitante::class);
    }

    public function ebdRegistro()
    {
        return $this->hasOne(EbdRegistro::class);
    }

    public function celestialRegistro()
    {
        return $this->hasOne(CelestialRegistro::class);
    }

    public function ofertas()
    {
        return $this->hasMany(Oferta::class);
    }

    public function getTotalOfertasAttribute(): float
    {
        if ($this->relationLoaded('ofertas')) {
            return (float) $this->ofertas->sum('valor_total');
        }

        return (float) $this->ofertas()->sum('valor_total');
    }

    /* Helpers */
    public function getDataFormatadaAttribute(): string
    {
        return $this->data->translatedFormat('l, d/m/Y');
    }

    public function getTipoLabelAttribute(): string
    {
        return match($this->tipo_evento) {
            'culto_dominical' => 'Culto Dominical',
            'culto_semana'    => 'Culto de Semana',
            'especial'        => 'Culto Especial',
            default           => $this->tipo_evento,
        };
    }
}
