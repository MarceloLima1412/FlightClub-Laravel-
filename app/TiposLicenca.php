<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TiposLicenca;

class TiposLicenca extends Model
{
    public $timestamps = false;
    protected $fillable=['code','nome'];
}
