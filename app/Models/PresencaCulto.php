<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresencaCulto extends Model
{
    protected $table = 'presencas_culto';

    protected $fillable = ['evento_id', 'adultos', 'adolescentes', 'criancas'];

    protected $casts = [
        'adultos'      => 'integer',
        'adolescentes' => 'integer',
        'criancas'     => 'integer',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    /* Virtual accessor — total não é coluna persistida */
    public function getTotalAttribute(): int
    {
        return (int)$this->adultos + (int)$this->adolescentes + (int)$this->criancas;
    }
}
