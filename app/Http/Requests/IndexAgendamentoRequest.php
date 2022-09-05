<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexAgendamentoRequest extends FormRequest
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
            //
        ];
    }

    public function getSearchCallback()
    {
        return function ($query) {

            // $termos = $this->only('none');

            // foreach ($termos as $nome => $valor) {
            //   if ($valor) {
            //     $query->where($nome, 'LIKE', '%' . $valor . '%');
            //   }
            // }

            $iguais = $this->only('filial_id', 'quadra_id');

            foreach ($iguais as $nome => $valor) {
                if ($valor) {
                    $query->where($nome, '=', $valor);
                }
            }
        };
    }
}
