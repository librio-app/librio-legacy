<?php

namespace App\Http\Requests\Member;

use App\Contracts\Validation\Rule\BookIsNotLended;
use App\Contracts\Validation\Rule\ReservationNotSamePerson;
use App\Http\Requests\Request;

class Reserve extends Request
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
            'reservation' => [
                'required',
                'string',
                'exists:book_barcodes,barcode,deleted_at,NULL',
                new BookIsNotLended(),
                new ReservationNotSamePerson($this->request->get('reservation', null), $this->request->get('member_id')),
            ]
        ];
    }
}
