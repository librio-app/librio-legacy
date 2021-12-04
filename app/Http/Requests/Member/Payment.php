<?php

namespace App\Http\Requests\Member;

use App\Http\Requests\Request;


class Payment extends Request
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
            'member_book_id' => [
                'exists:member_books,id',
            ]
        ];
    }
}
