<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Barcode extends FormRequest
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
        if ($this->getMethod() === 'PATCH') {
            $id = $this->book_barcode;
        } else {
            $id = null;
        }

        return [
            'book' => 'exists:books,id,deleted_at,NULL',
            'barcode' => 'required|unique:book_barcodes,barcode,' . $id . ',id,deleted_at,NULL',
        ];
    }
}
