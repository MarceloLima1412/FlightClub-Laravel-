<?php

namespace App;

use App\User;
use App\Aeronaves_valore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aeronave extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'matricula';
    public $incrementing = false;

 protected $fillable=['matricula','marca','modelo','num_lugares','conta_horas','preco_hora','tipo_certificacao'];

 public function pilotos(){
     return $this->belongsToMany(User::class, 'aeronaves_pilotos', 'matricula', 'piloto_id'); //associa a tabela 'aeronaves_pilotos, com o campo matricula associa aos users 
 }

 public function movimentos(){
     return $this->hasMany(Movimento::class, 'aeronave','matricula');
 }

 public function valores(){
    return $this->hasMany(Aeronaves_valore::class, 'matricula','matricula');
}

}
;