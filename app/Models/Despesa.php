<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    protected $fillable = [
        'data','descricao','categoria','valor','moeda',
        'forma_pagamento','comprovante_url','observacao',
    ];

    protected $casts = ['data' => 'date', 'valor' => 'float'];

    public function getValorFormatadoAttribute(): string
    {
        return number_format($this->valor, 2, ',', '.') . ' Kz';
    }

    public function getFormaPagamentoLabelAttribute(): string
    {
        return match($this->forma_pagamento) {
            'dinheiro'     => 'Dinheiro',
            'transferencia'=> 'Transferência Bancária',
            'cartao'       => 'Cartão',
            'multicaixa'   => 'Multicaixa / TPA',
            'cheque'       => 'Cheque',
            default        => $this->forma_pagamento,
        };
    }
}
