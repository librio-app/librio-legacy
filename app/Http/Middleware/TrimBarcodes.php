<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class TrimBarcodes extends TransformsRequest
{
    /**
     * Attributes that needs to be stripped of spaces
     * @var string[]
     */
    protected $attributes = [
        'barcode',
        'reservation',
    ];

    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        if (in_array($key, $this->attributes, true)) {
            return preg_replace('/\s+/', '', $value);
        }

        return $value;
    }
}
