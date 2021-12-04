<?php

namespace App\Http\Requests\Catalog;

use App\Http\Requests\Request;

class Series extends Request
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
        // Check if store or update
        if ($this->getMethod() == 'PATCH') {
            $id = $this->series->getAttribute('id');
        } else {
            $id = null;
        }

        return [
            'title' => 'required|string',
            'code' => 'required|unique:publishers,code,' . $id . ',id',
        ];
    }
}
