<?php

namespace App\Http\Requests;

use App\TiposLicenca;
use Illuminate\Foundation\Http\FormRequest;

class StoreTipoLicencaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     *

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'=>'required',
            'nome'=>'required'
           
        ];
    }
    public function messages(){
        return [
            ];
    }
}
