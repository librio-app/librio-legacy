<?php

namespace App\Http\Requests\Member;

use App\Contracts\Validation\Rule\BarcodeExists;
use App\Contracts\Validation\Rule\BookIsNotLended;
use App\Http\Requests\Request;


class TakeIn extends Request
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
            'barcode' => [
                'required',
                'string',
                new BarcodeExists(),
                new BookIsNotLended(),
            ]
        ];
    }
}
