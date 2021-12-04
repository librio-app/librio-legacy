<?php

namespace App\Http\Requests\Member;

use App\Contracts\Validation\Rule\BarcodeExists;
use App\Contracts\Validation\Rule\BookIsLended;
use App\Contracts\Validation\Rule\SubscriptionLimitRule;
use App\Http\Requests\Request;

class Lend extends Request
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
                new BookIsLended(),
            ],
            'member_id' => [
                'required',
                'string',
                'exists:members,id,deleted_at,NULL',
                new SubscriptionLimitRule(),
            ]
        ];
    }
}

