<?php


namespace App\Contracts\Validation\Rule;

use Illuminate\Contracts\Validation\Rule;

class BarcodeExists implements Rule
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->value = $value;
        $barcode = \DB::table('book_barcodes')
            ->where('book_barcodes.barcode', $value)
            ->whereNull('book_barcodes.deleted_at')
            ->get()->first();

        if ($barcode) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return trans('validation.exists_barcode', [
            'attribute' => trans_choice('general.barcodes', 1),
            'value' => $this->value
        ]);
    }
}
