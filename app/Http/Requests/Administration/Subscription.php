<?php

namespace App\Http\Requests\Administration;

use Illuminate\Foundation\Http\FormRequest;

class Subscription extends FormRequest
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
            $id = $this->subscription->getAttribute('id');
        } else {
            $id = null;
        }

        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'book_limit' => 'required|integer',
            'book_lending_days' => 'required|integer',
            'currency' => 'required|string',
            'subscription_price' => 'required|between:0,99.99',
            'penalty' => 'required|boolean',
            'penalty_price' => 'nullable|between:0,99.99',
            'payment_period' => '',
            'enabled' => 'required|boolean',
        ];
    }
}
