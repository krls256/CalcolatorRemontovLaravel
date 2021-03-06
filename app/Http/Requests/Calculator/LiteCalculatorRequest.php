<?php

namespace App\Http\Requests\Calculator;

use Illuminate\Foundation\Http\FormRequest;

class LiteCalculatorRequest extends FormRequest
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
            'type'    => 'required|numeric',
            'typeRem' => 'required|numeric|max:5',
            'rooms' => 'required|numeric',
            'aere' => 'required|numeric|min:1',
        ];
    }
}
