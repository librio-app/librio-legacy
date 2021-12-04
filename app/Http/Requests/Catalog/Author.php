<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;

class Author extends FormRequest
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
            $id = $this->author->getAttribute('id');
        } else {
            $id = null;
        }

        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'code' => 'required|unique:authors,code,' . $id . ',id',
            'birthday' => 'nullable|date',
            'enabled' => 'required|boolean',
        ];
    }
}
