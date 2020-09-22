<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAeronaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'matricula'=>'required|unique:aeronaves,matricula|min:3|max:8',
            'marca'=>'required|max:40',
            'modelo'=>'required|max:40',
            'num_lugares'=>'required|integer|min:1',
            'conta_horas'=>'required|integer|min:1',
            'preco_hora'=>'required|numeric|min:0',
            'minutos'=> 'array|min:10|max:10',
            'preco'=> 'array|min:10|max:10',
            'tempos.*'=> 'integer | required | min:0 ',
            'preco.*'=> 'numeric | required | min:0',
            'tipo_certificacao' => 'required|in:C,X,UL'
        ];
    }
    public function messages(){
        return ['matricula.min'=> 'A matricula tem de ter pelo menos 3 caracteres',
                'conta_horas.integer'=> 'Conta horas só aceita carateres inteiros',
                'preco_hora.integer'=> 'Conta horas só aceita carateres inteiros'
            ];
    }
}
