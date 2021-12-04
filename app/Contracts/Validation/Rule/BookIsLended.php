<?php


namespace App\Contracts\Validation\Rule;

use Illuminate\Contracts\Validation\Rule;

class BookIsLended implements Rule
{
    public function passes($attribute, $value)
    {
        $lended = \DB::table('member_books')
            ->join('book_barcodes', 'member_books.book_barcode_id', '=', 'book_barcodes.id')
            ->where('book_barcodes.barcode', $value)
            ->whereNull('member_books.take_in_at')
            ->get()->first();

        if ($lended) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return trans('validation.lended');
    }
}
