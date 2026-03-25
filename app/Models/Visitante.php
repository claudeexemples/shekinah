<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    protected $fillable = [
        'evento_id', 'nome', 'telefone', 'email', 'idade',
        'tipo', 'primeira_visita', 'data_visita', 'como_conheceu',
        'acompanhado', 'status', 'bairro', 'municipio', 'provincia', 'observacoes',
    ];

    protected $casts = [
        'primeira_visita' => 'boolean',
        'acompanhado'     => 'boolean',
        'data_visita'     => 'date',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pendente'    => 'Pendente',
            'acompanhado' => 'Acompanhado',
            'convertido'  => 'Convertido',
            'inativo'     => 'Inactivo',
            default       => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pendente'    => 'badge-warning',
            'acompanhado' => 'badge-success',
            'convertido'  => 'badge-primary',
            'inativo'     => 'badge-neutral',
            default       => 'badge-neutral',
        };
    }

    public function getTipoLabelAttribute(): string
    {
        return match($this->tipo) {
            'adulto'      => 'Adulto',
            'adolescente' => 'Adolescente',
            'crianca'     => 'Criança',
            default       => $this->tipo,
        };
    }
}
