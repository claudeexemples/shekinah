<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $fillable = [
        'evento_id','tipo','valor_dinheiro','valor_transferencia',
        'valor_cartao','valor_total','moeda','observacao',
    ];

    protected $casts = [
        'valor_dinheiro'      => 'float',
        'valor_transferencia' => 'float',
        'valor_cartao'        => 'float',
        'valor_total'         => 'float',
    ];

    public function evento() { return $this->belongsTo(Evento::class); }

    public function getValorFormatadoAttribute(): string
    {
        return number_format($this->valor_total, 2, ',', '.') . ' Kz';
    }

    protected static function booted(): void
    {
        static::saving(function (Oferta $o) {
            $o->valor_total = $o->valor_dinheiro + $o->valor_transferencia + $o->valor_cartao;
        });
    }
}
