<?php

namespace App;

use App\User;
use App\Aeronave;
use App\Aerodromo;
use Illuminate\Database\Eloquent\Model;

//use Illuminate\Database\Eloquent\SoftDeletes;

class Movimento extends Model
{
    //use SoftDeletes;

    //protected $primaryKey = 'matricula';
    //public $incrementing = true; //SÓ QUERO INCREMENTAR O ID, VERIFICAR

 protected $fillable=['data','hora_descolagem','hora_aterragem','aeronave','num_diario','num_servico','piloto_id','num_licenca_piloto',
 'tipo_licenca_piloto','validade_licenca_piloto','num_certificado_piloto','natureza','aerodromo_partida',
 'aerodromo_chegada','num_aterragens','num_descolagens','num_pessoas','conta_horas_inicio','conta_horas_fim','tempo_voo','preco_voo','modo_pagamento',
 'num_recibo','confirmado','observacoes','tipo_instrucao','instrutor_id','num_licenca_instrutor',
 'tipo_licenca_instrutor','validade_licenca_instrutor','num_certificado_instrutor','validade_certificado_instrutor','validade_certificado_piloto','classe_certificado_instrutor','classe_certificado_piloto '];
//SE FOR UM VOO DE DE INSTRUÇÃO, FALTAM MAIS DADOS

    public function piloto(){
        return $this->belongsTo(User::class,'piloto_id')->withTrashed();
    }

    public function instrutor(){
        return $this->belongsTo(User::class,'instrutor_id')->withTrashed();
    }

    public function aeronaveMov(){
        return $this->belongsTo(Aeronave::class,'aeronave','matricula')->withTrashed();
    }
    
}
;