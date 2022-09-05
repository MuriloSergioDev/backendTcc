<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
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
            'filial_id' => 'required',
            'nome' => 'required|max:125',
            'cpf' => 'required|unique:clientes|max:125',
            'email' => 'required|max:125',
            'telefone' => 'required|max:125',
            'logradouro' => 'required|max:125',
            'numero' => 'required|max:125',
            'complemento' => 'required|max:125',
            'bairro' => 'required|max:125',
            'cep' => 'required|max:125',
            'cidade' => 'required|max:125',
            'estado' => 'required|max:2',
            'data_nascimento' => 'required|max:125',
        ];
    }

    public function validationData()
    {
        $data = $this->all();

        $data['cpf'] = preg_replace('/[^0-9]/', '', $data['cpf']);

        $this->replace($data);

        return $data;
    }
}
