<?php


namespace App\Http\Requests\Administration;


use Illuminate\Foundation\Http\FormRequest;

class Member extends FormRequest
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
            $id = $this->member->getAttribute('id');
        } else {
            $id = null;
        }

        $validation = [
            'code' => 'required|unique:members,code,' . $id . ',id',
            'first_name' => 'required|string',
            'insertion' => 'nullable|string',
            'last_name' => 'required|string',
            'birthday' => 'nullable|date',
            'comment' => 'nullable|string',
            'email' => 'required|email|unique:members,email,' . $id . ',id,deleted_at,NULL',
            'account' => 'boolean',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'zipcode' => 'required|string',
            'city' => 'required|string',
//            'state' => 'nullable|string',
            'subscription_id' => 'exists:subscriptions,id,deleted_at,NULL',
            'active' => 'boolean',
        ];

        // only when account is active
        if ($id === null && (bool) $this->get('account') === true) {
            $validation['password'] = 'required|confirmed';
        }

        return $validation;
    }
}
