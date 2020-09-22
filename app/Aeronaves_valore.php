<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aeronaves_valore extends Model
{
    protected $fillable=['id','matricula','unidade_conta_horas','minutos','preco'];
    public $timestamps = false;
    public function aeronaves(){
        return $this->belongsTo(Aeronave::class, 'matricula','matricula');
    }
}
