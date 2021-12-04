<?php

namespace App\Http\Requests\Chart;

use Illuminate\Foundation\Http\FormRequest;

class Lended extends FormRequest
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
            'year' => 'nullable|integer',
            'month' => 'nullable|integer',
        ];
    }
}
