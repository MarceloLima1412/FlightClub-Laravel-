<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aerodromo extends Model
{
    use SoftDeletes;
    
    protected $fillable=['code','nome','militar','ultraleve'];
}
