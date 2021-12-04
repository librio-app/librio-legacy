<?php

namespace App\Http\Requests\Catalog;

use App\Http\Requests\Request;

class Theme extends Request
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
            'name' => 'required|string',
            'active' => 'boolean',
            'start_at' => 'date|nullable',
            'end_at' => 'date|nullable',
        ];
    }
}
