<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PresencaDoutrinaria extends Model
{
    protected $table = 'presencas_doutrinaria';
    protected $fillable = ['turma_id','candidato_id','aula_numero','data_aula','presente','observacao'];
    protected $casts = ['presente' => 'boolean', 'data_aula' => 'date'];

    public function candidato() { return $this->belongsTo(CandidatoBatismo::class, 'candidato_id'); }
    public function turma()     { return $this->belongsTo(TurmaDoutrinaria::class,  'turma_id'); }
}
