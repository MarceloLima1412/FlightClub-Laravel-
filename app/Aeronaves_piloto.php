<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aeronaves_piloto extends Model
{
    protected $fillable=['id','matricula', 'piloto_id'];

    public function aeronaves(){
        return $this->belongsTo(Aeronave::class, 'matricula','matricula');
    }
}
