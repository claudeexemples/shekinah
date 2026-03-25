<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CelestialRegistro extends Model {
    protected $table = 'celestial_registros';
    protected $fillable = ['evento_id','total_criancas','total_professores','observacoes'];
    public function evento() { return $this->belongsTo(Evento::class); }
}
