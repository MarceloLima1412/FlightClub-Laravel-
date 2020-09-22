<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovimentoRequest extends FormRequest
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
            'data' => 'required|date_format:"Y-m-d"|before_or_equal:today',
            'hora_descolagem' => 'required|date_format:"H:i"',
            'hora_aterragem' => 'required|date_format:"H:i"|after:hora_descolagem',
            'aeronave' => 'required|exists:aeronaves,matricula',
            'num_diario' => 'required|integer|min:1',
            'num_servico' => 'required|integer|min:1',
            'piloto_id' => 'required|exists:users,id',
            'natureza' => 'required|in:T,I,E',
            'aerodromo_partida' => 'required|exists:aerodromos,code',
            'aerodromo_chegada' => 'required|exists:aerodromos,code',
            'num_aterragens' => 'required|integer|min:1',
            'num_descolagens' => 'required|integer|min:1',
            'num_pessoas' => 'required|integer|min:1',
            'conta_horas_inicio' => 'required|integer|min:1',
            'conta_horas_fim' => 'required|integer|min:1|gt:conta_horas_inicio',
            //TEMPOS:  'tempos'=> 'required|min:10|max:10|array',
            //          'tempos.*' => 'required|integer',
            'tempo_voo' => 'sometimes|required|integer|min:1',
            'preco_voo' => 'sometimes|required|min:1|numeric',
            'modo_pagamento' => 'required|in:N,M,T,P',
            'num_recibo' => 'required|min:1|max:20',
            'observacoes' => 'nullable',
        ];
    }

    public function messages(){
        return [/*'data.date_format'=> 'A data tem de ter o seguinte formato: dd/mm/yyyy .',
                'hora_descolagem.date_format'=> 'A data tem de ter o seguinte formato: dd/mm/yyyy hh:mm .',
                'hora_descolagem.date_format'=> 'A data tem de ter o seguinte formato: dd/mm/yyyy hh:mm .',
                'data.before'=>'Coloque uma data igual/superior à data de hoje!'*/
            ];
    }
}
