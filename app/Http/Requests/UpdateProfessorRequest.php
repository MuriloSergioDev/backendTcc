<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfessorRequest extends FormRequest
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
            'nome' => 'required|max:125',
        ];
    }

    // public function validationData()
    // {
    //     $data = $this->all();

    //     $data['cpf'] = preg_replace('/[^0-9]/', '', $data['cpf']);

    //     $this->replace($data);

    //     return $data;
    // }
}
