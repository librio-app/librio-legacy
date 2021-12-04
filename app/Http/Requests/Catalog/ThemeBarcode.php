<?php

namespace App\Http\Requests\Catalog;

use App\Http\Requests\Request;

class ThemeBarcode extends Request
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
            'barcode' => 'exists:book_barcodes,id,deleted_at,NULL',
        ];
    }
}
