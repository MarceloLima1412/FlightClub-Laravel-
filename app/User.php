<?php

namespace App;

use App\Movimento;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;     // RESET da password
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    use SoftDeletes;

    //protected $primaryKey = 'id';
    //public $incrementing = false;

    protected $fillable=['nome_informal', 'name', 'password', 'password_inicial','sexo','num_socio','data_nascimento', 'email','foto_url','nif', 'telefone' ,'endereco','tipo_socio','ativo','password_inicial','direcao', 'quota_paga', 'licenca_confirmada', 'certificado_confirmado', 'num_licenca', 'tipo_licenca', 'num_certificado', 'classe_certificado', 'validade_licenca', 'validade_certificado', 'aluno', 'instrutor', ''];

    public function movimentosP(){
        return $this->hasMany(Movimento::class,'piloto_id','id');
    }

    public function movimentosI(){
        return $this->hasMany(Movimento::class,'instrutor_id','id');
    }

    
 
    //belongsToMany(Aeronave::class,'aeronave','aeronave_pilotos','matricula','piloto_id)
}



