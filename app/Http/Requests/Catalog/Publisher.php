<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;

class Publisher extends FormRequest
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
            $id = $this->publisher->getAttribute('id');
        } else {
            $id = null;
        }

        return [
            'name' => 'required|string',
            'code' => 'required|unique:publishers,code,' . $id . ',id',
            'enabled' => 'required|boolean',
        ];
    }
}
