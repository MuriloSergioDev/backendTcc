<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventoRecorrenteRequest extends FormRequest
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
            'bloco_id' => 'required',
            'sala_id' => 'required',
            'professor_id' => 'nullable',
            'tipo_id' => 'required',
            'title' => 'required|max:191',
            'description' => 'nullable',
        ];
    }
}
