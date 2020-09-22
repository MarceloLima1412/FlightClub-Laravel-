<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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

            'name' => 'required|min:3|regex:/^[A-ZÀ-úa-z\s]+$/',
            'nome_informal' => 'required|min:3|max:40|regex:/^[A-ZÀ-úa-z0-9\s]+$/',
            'nif' => 'nullable|min:9|max:9',
            'telefone' => 'nullable|min:9|max:20',
            'data_nascimento' => 'required|date|before:today|date_format:Y-m-d',
            'email' => 'required|email|unique:users,email',
            'num_socio' => 'required|unique:users,num_socio|integer|min:1',
            'tipo_socio' => 'required|in:P,NP,A',
            'endereco' => 'nullable',
            'sexo' => 'required|in:F,M',
            'direcao' => 'required|in:0,1',
            'ativo' => 'required|in:0,1',
            'quota_paga' => 'required|in:0,1',
            //'aluno' => ['nullable','in:0,1',new ValidateInstrutorAluno($this->intrutor)],
            //'intrutor' => ['nullable','in:0,1',new ValidateInstrutorAluno($this->aluno)],
            'file_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // foto_url
            'file_licenca' => 'nullable|mimes:pdf|max:2048',
            'file_certificado' => 'nullable|mimes:pdf|max:2048',
            
            'instrutor' => 'nullable|in:0,1', //o null é incluido em nullable
            'aluno' => 'nullable|in:0,1',
             'num_licenca' => 'nullable|max:30',
            'tipo_licenca' => 'nullable|max:20|exists:tipos_licencas,code',   
            'validade_licenca' => 'nullable|date|date_format:Y-m-d',
            'licenca_confirmada' => 'nullable|in:0,1',
            'num_certificado' => 'nullable|max:30',
            'classe_certificado' => 'nullable|max:20|exists:classes_certificados,code',
            'validade_certificado' => 'nullable|date|date_format:Y-m-d',
            'certificado_confirmado' => 'nullable|in:0,1'

        ];
    }

    public function messages()
    {
        return [

            'name.min'=> 'O nome tem de ter pelo menos 3 caracteres.',
            'nome_informal.min'=> 'O nome tem de ter pelo menos 3 caracteres.',
            'data_nascimento.date' => 'A data de nascimento tem de ser válida e no formato "YYYY-mm-dd".',
            'email.email'=> 'O endereço email tem de ser válido.',
            'preco_hora.integer'=> 'Conta horas só aceita carateres inteiros.'

            ];
    }

}
