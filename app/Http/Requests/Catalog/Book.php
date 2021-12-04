<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;

class Book extends FormRequest
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
            $id = $this->book->getAttribute('id');
        } else {
            $id = null;
        }

        return [
            'code' => 'required|unique:books,code,' . $id . ',id',
            'title' => 'required|string',
            'series_id' => 'required_with:series_nr|string|nullable',
            'series_nr' => 'string|nullable',
            'type_id' => 'exists:types,id,deleted_at,NULL',
            'category_id' => 'exists:categories,id,deleted_at,NULL',
            'publisher_id' => 'exists:publishers,id,deleted_at,NULL',
            'author_id' => 'exists:authors,id,deleted_at,NULL',
            'enabled' => 'required|boolean',
        ];
    }
}
