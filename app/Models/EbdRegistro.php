<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EbdRegistro extends Model {
    protected $table = 'ebd_registros';
    protected $fillable = ['evento_id','professor','tema','total_presentes','observacoes'];
    public function evento() { return $this->belongsTo(Evento::class); }
}
